---
source: Official Laravel Docs (webfetch) + Context7 API
library: Laravel
topic: Upgrade Guide 13.0 from 12.x
fetched: 2026-04-30T00:00:00Z
official_docs: https://laravel.com/docs/13.x/upgrade
---

# Laravel 13.0 Upgrade Guide — Upgrading From 12.x

**Estimated Upgrade Time:** 10 Minutes
**PHP Minimum:** 8.3

---

## HIGH IMPACT CHANGES

### 1. Updating Dependencies

**Likelihood Of Impact: HIGH**

Update your `composer.json`:

```diff
- "laravel/framework": "^12.0",
+ "laravel/framework": "^13.0",
- "laravel/boost": "^1.0",
+ "laravel/boost": "^2.0",
- "laravel/tinker": "^2.0",
+ "laravel/tinker": "^3.0",
- "phpunit/phpunit": "^11.0",
+ "phpunit/phpunit": "^12.0",
- "pestphp/pest": "^3.0",
+ "pestphp/pest": "^4.0",
```

### 2. Updating the Laravel Installer

If using the Laravel installer CLI:
```
composer global update laravel/installer
```

Or update your [Laravel Herd](https://herd.laravel.com) installation.

### 3. Request Forgery Protection (CSRF)

**Likelihood Of Impact: HIGH**

The CSRF middleware has been **renamed** from `VerifyCsrfToken` to `PreventRequestForgery`, and now includes request-origin verification using the `Sec-Fetch-Site` header.

`VerifyCsrfToken` and `ValidateCsrfToken` remain as deprecated aliases but should be updated:

```diff
- use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
+ use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

- ->withoutMiddleware([VerifyCsrfToken::class]);
+ ->withoutMiddleware([PreventRequestForgery::class]);
```

---

## MEDIUM IMPACT CHANGES

### 4. Cache `serializable_classes` Configuration

**Likelihood Of Impact: MEDIUM**

The default `config/cache.php` now includes `'serializable_classes' => false`. This hardens cache unserialization behavior to prevent PHP deserialization gadget chain attacks if `APP_KEY` is leaked.

If your application intentionally stores PHP objects in cache, you must explicitly list allowed classes:

```php
'serializable_classes' => [
    App\Data\CachedDashboardStats::class,
    App\Support\CachedPricingSnapshot::class,
],
```

If you relied on unserializing arbitrary cached objects, migrate to explicit allow-lists or use arrays.

### 5. Database `upsert` With MySQL or MariaDB

**Likelihood Of Impact: MEDIUM**

Laravel now validates that `uniqueBy` is non-empty for `upsert()`. An `InvalidArgumentException` will be thrown if `uniqueBy` is empty. Previously it silently generated invalid SQL.

```php
// Now throws InvalidArgumentException if uniqueBy is empty:
DB::table('users')->upsert($values, [], ['name']);
```

---

## LOW IMPACT CHANGES

### 6. Cache Prefixes and Session Cookie Names

**Likelihood Of Impact: LOW**

Default cache/Redis key prefixes now use hyphenated suffixes instead of underscore-separated ones:

```php
// Laravel <= 12.x
Str::slug((string) env('APP_NAME', 'laravel'), '_').'_cache_';
Str::slug((string) env('APP_NAME', 'laravel'), '_').'_database_';
Str::slug((string) env('APP_NAME', 'laravel'), '_').'_session';

// Laravel >= 13.x
Str::slug((string) env('APP_NAME', 'laravel')).'-cache-';
Str::slug((string) env('APP_NAME', 'laravel')).'-database-';
Str::slug((string) env('APP_NAME', 'laravel')).'-session';
```

To retain previous behavior, explicitly configure `CACHE_PREFIX`, `REDIS_PREFIX`, and `SESSION_COOKIE` in your `.env`.

### 7. Collection Model Serialization Restores Eager-Loaded Relations

**Likelihood Of Impact: LOW**

When Eloquent model collections are serialized and restored (e.g., in queued jobs), eager-loaded relations are now restored. If your code depended on relations being absent after deserialization, update that logic.

### 8. `Container::call` and Nullable Class Defaults

**Likelihood Of Impact: LOW**

`Container::call` now respects nullable class parameter defaults when no binding exists:

```php
$container->call(function (?Carbon $date = null) {
    return $date;
});

// Laravel <= 12.x: Carbon instance
// Laravel >= 13.x: null
```

### 9. Domain Route Registration Precedence

**Likelihood Of Impact: LOW**

Routes with an explicit domain are now prioritized before non-domain routes in route matching. If your application relied on previous registration precedence between domain and non-domain routes, review route matching behavior.

### 10. `JobAttempted` Event Exception Payload

**Likelihood Of Impact: LOW**

The `Illuminate\Queue\Events\JobAttempted` event now exposes the exception object (or `null`) via `$exception`, replacing the previous boolean `$exceptionOccurred`:

```diff
- $event->exceptionOccurred;
+ $event->exception;
```

### 11. Manager `extend` Callback Binding

**Likelihood Of Impact: LOW**

Custom driver closures registered via manager `extend` methods are now bound to the manager instance. If you previously relied on another bound object as `$this`, move those values into closure captures using `use (...)`.

### 12. MySQL `DELETE` Queries With `JOIN`, `ORDER BY`, and `LIMIT`

**Likelihood Of Impact: LOW**

Laravel now compiles full `DELETE ... JOIN` queries including `ORDER BY` and `LIMIT` for MySQL grammar. Database engines that don't support this syntax may now throw a `QueryException` instead of silently ignoring the clauses.

### 13. Pagination Bootstrap View Names

**Likelihood Of Impact: LOW**

Internal pagination view names for Bootstrap 3 defaults are now explicit:

```diff
- pagination::default
+ pagination::bootstrap-3
- pagination::simple-default
+ pagination::simple-bootstrap-3
```

### 14. Polymorphic Pivot Table Name Generation

**Likelihood Of Impact: LOW**

When table names are inferred for polymorphic pivot models using custom pivot model classes, Laravel now generates pluralized names. If you depended on previous singular inferred names, explicitly define the table name on your pivot model.

### 15. `QueueBusy` Event Property Rename

**Likelihood Of Impact: LOW**

The `Illuminate\Queue\Events\QueueBusy` event property `$connection` has been renamed to `$connectionName`:

```diff
- $event->connection;
+ $event->connectionName;
```

### 16. `Str` Factories Reset Between Tests

**Likelihood Of Impact: LOW**

Laravel now resets custom `Str` factories (UUID/ULID/random string) during test teardown. Set them in each relevant test or setup hook if needed.

### 17. Symfony PHP 8.5 Polyfill and Global Function Conflicts

**Likelihood Of Impact: LOW**

Laravel 13 depends on `symfony/polyfill-php85`. On PHP < 8.5, this defines global functions `array_first()` and `array_last()`. These may conflict with `laravel/helpers` or custom global helpers.

To avoid conflicts, prefer `Illuminate\Support\Arr` methods:

```php
use Illuminate\Support\Arr;
Arr::first($array, function ($value) {
    return /* condition */;
});
```

---

## VERY LOW IMPACT CHANGES

### 18. Cache `Store` and `Repository` Contracts: `touch`

The cache contracts now include a `touch($key, $seconds)` method. Add this to custom cache store implementations.

### 19. `Dispatcher` Contract: `dispatchAfterResponse`

`Illuminate\Contracts\Bus\Dispatcher` now includes `dispatchAfterResponse($command, $handler = null)`. Add this to custom dispatcher implementations.

### 20. `ResponseFactory` Contract: `eventStream`

`Illuminate\Contracts\Routing\ResponseFactory` now includes an `eventStream` signature. Add this to custom implementations.

### 21. `MustVerifyEmail` Contract: `markEmailAsUnverified`

`Illuminate\Contracts\Auth\MustVerifyEmail` now includes `markEmailAsUnverified()`. Add this to custom implementations.

### 22. HTTP Client `Response::throw` and `throwIf` Signatures

Methods now declare callback parameters in signatures. If you override these, ensure signatures are compatible:
```php
public function throw($callback = null);
public function throwIf($condition, $callback = null);
```

### 23. Default Password Reset Subject

Subject changed from "Reset Password Notification" to "Reset your password". Update tests/assertions that depend on the old string.

### 24. Queued Notifications and Missing Models

Queued notifications now respect `#[DeleteWhenMissingModels]` attribute and `$deleteWhenMissingModels` property. Missing models will now properly delete the job.

### 25. `Queue` Contract Method Additions

Add implementations for `pendingSize`, `delayedSize`, `reservedSize`, `creationTimeOfOldestPendingJob` to custom queue driver implementations.

### 26. `withScheduling` Registration Timing

Schedules registered via `ApplicationBuilder::withScheduling()` are now deferred until `Schedule` is resolved.

### 27. Model Booting and Nested Instantiation

Creating a new model instance while that model is still booting now throws a `LogicException`:

```php
// NO LONGER ALLOWED:
protected static function boot()
{
    parent::boot();
    (new static())->getTable(); // Throws LogicException
}
```

Move this logic outside the boot cycle.

### 28. `Js::from` Uses Unescaped Unicode By Default

`Illuminate\Support\Js::from` now uses `JSON_UNESCAPED_UNICODE`. Update tests that depended on escaped Unicode sequences (e.g., `\u00e8`).

---

## CHANGES SUMMARY TABLE

| Area | Impact | Change |
|------|--------|--------|
| Dependencies | HIGH | PHP 8.3+, laravel/framework ^13.0, phpunit ^12.0, pest ^4.0, tinker ^3.0, boost ^2.0 |
| CSRF/Security | HIGH | `VerifyCsrfToken` → `PreventRequestForgery` middleware rename + origin verification |
| Cache config | MEDIUM | New `serializable_classes` option (default: false) |
| Database upsert | MEDIUM | Empty `uniqueBy` now throws `InvalidArgumentException` |
| Cache prefixes | LOW | Hyphenated suffixes instead of underscores |
| Eloquent collection serialization | LOW | Eager-loaded relations restored after deserialization |
| Container::call | LOW | Nullable class defaults respected |
| Domain route precedence | LOW | Domain routes prioritized over non-domain |
| JobAttempted event | LOW | `$exceptionOccurred` → `$exception` (object now) |
| Manager extend | LOW | Callback bound to manager instance |
| MySQL DELETE + JOIN | LOW | ORDER BY/LIMIT now included in SQL |
| Pagination views | LOW | `pagination::default` → `pagination::bootstrap-3` |
| Polymorphic pivot tables | LOW | Pluralized name generation |
| QueueBusy event | LOW | `$connection` → `$connectionName` |
| Str factories | LOW | Reset between tests |
| Symfony polyfill | LOW | `array_first`/`array_last` conflicts possible |
| Model booting | VERY LOW | Nested instantiation throws LogicException |
| Cache contract | VERY LOW | New `touch()` method |
| Dispatcher contract | VERY LOW | New `dispatchAfterResponse()` method |
| ResponseFactory contract | VERY LOW | New `eventStream()` method |
| MustVerifyEmail contract | VERY LOW | New `markEmailAsUnverified()` method |
| Password reset subject | VERY LOW | "Reset your password" (was "Reset Password Notification") |
| Js::from | VERY LOW | Uses JSON_UNESCAPED_UNICODE |

---

## HOW TO UPGRADE USING AI

You can automate this upgrade using [Laravel Boost](https://github.com/laravel/boost) ^2.0. Once installed, use the `/upgrade-laravel-v13` slash command in Claude Code, Cursor, OpenCode, Gemini, or VS Code.

---

## OFFICIAL UPGRADE TOOLS

- **Upgrade Guide:** https://laravel.com/docs/13.x/upgrade
- **Release Notes:** https://laravel.com/docs/13.x/releases
- **GitHub Diff (12.x → 13.x):** https://github.com/laravel/laravel/compare/12.x...13.x
- **Laravel Shift (community):** https://laravelshift.com/
