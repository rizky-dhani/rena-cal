---
source: Spatie Official Docs + Context7 API
library: spatie/laravel-permission
package: spatie/laravel-permission
topic: Upgrade from v6 to v7
fetched: 2026-04-30T12:00:00Z
official_docs: https://spatie.be/docs/laravel-permission/v7/upgrading
---

# Upgrading from v6 to v7 - spatie/laravel-permission

## General Upgrade Essentials (ALL upgrades)

1. **Composer**: Update `composer.json` to `^7.0`, then run `composer update spatie/laravel-permission`
2. **Migrations**: Compare the migration file stubs in the new version against your existing migrations. Create a new migration by hand if needed.
3. **Config file**: Backup your existing `config/permission.php`, re-publish the new one, and re-apply your customizations.
4. **Models**: If you extended models, compare old vs new models and apply relevant updates.
5. **Custom Methods/Traits**: If you overrode any trait methods, compare old and new traits, apply updates.
6. **Contract/Interface updates**: Check for method signature changes if you implemented contracts.
7. **Apply version-specific changes** (see below).
8. **Review the [CHANGELOG](https://github.com/spatie/laravel-permission/blob/main/CHANGELOG.md)** and [Release Notes](https://github.com/spatie/laravel-permission/releases).

---

## v6 → v7 Specific Upgrade Steps

### 1. Requirements

| Requirement | v6 | v7 |
|-------------|----|----|
| **PHP** | ^8.0 | ^8.3 (originally ^8.4 at launch, downgraded to ^8.3 in v7.3.0) |
| **Laravel** | ^10.0+ | ^12.0+ |
| **Lumen** | Supported | **Removed** |

> **⚠️ Note on PHP version**: v7.0.0 originally required PHP ^8.4. In v7.1.0, support for PHP 8.3 was added back. v7.3.0 officially changed the requirement to ^8.3.

### 2. Service Provider Changes

The service provider now extends `PackageServiceProvider` from `spatie/laravel-package-tools`.

- If you published or extended the service provider, update references accordingly.
- Lumen support has been removed entirely.

### 3. Event Class Renames (BREAKING)

All event classes now have an `Event` suffix. Update any event listeners that reference these classes:

| v6 (old) | v7 (new) |
|----------|----------|
| `Spatie\Permission\Events\PermissionAttached` | `Spatie\Permission\Events\PermissionAttachedEvent` |
| `Spatie\Permission\Events\PermissionDetached` | `Spatie\Permission\Events\PermissionDetachedEvent` |
| `Spatie\Permission\Events\RoleAttached` | `Spatie\Permission\Events\RoleAttachedEvent` |
| `Spatie\Permission\Events\RoleDetached` | `Spatie\Permission\Events\RoleDetachedEvent` |

Events must be enabled in `config/permission.php`:
```php
'events_enabled' => true,
```

### 4. Command Class Renames (BREAKING)

All command classes now have a `Command` suffix. Artisan command signatures remain unchanged:

| v6 (old) | v7 (new) |
|----------|----------|
| `Spatie\Permission\Commands\CacheReset` | `Spatie\Permission\Commands\CacheResetCommand` |
| `Spatie\Permission\Commands\CreateRole` | `Spatie\Permission\Commands\CreateRoleCommand` |
| `Spatie\Permission\Commands\CreatePermission` | `Spatie\Permission\Commands\CreatePermissionCommand` |
| `Spatie\Permission\Commands\Show` | `Spatie\Permission\Commands\ShowCommand` |
| `Spatie\Permission\Commands\UpgradeForTeams` | `Spatie\Permission\Commands\UpgradeForTeamsCommand` |
| `Spatie\Permission\Commands\AssignRole` | `Spatie\Permission\Commands\AssignRoleCommand` |

### 5. Removed Deprecated Methods

- `PermissionRegistrar::clearClassPermissions()` has been **removed**. Use `clearPermissionsCollection()` instead.

### 6. Type Hint Changes (BREAKING if extended)

Return types and parameter types have been added throughout the codebase. If you extended any of these, update signatures:

| Method | New Return Type |
|--------|----------------|
| `HasPermissions::givePermissionTo()` | `static` |
| `HasPermissions::syncPermissions()` | `static` |
| `HasPermissions::revokePermissionTo()` | `static` |
| `HasRoles::assignRole()` | `static` |
| `HasRoles::removeRole()` | `static` |
| `HasRoles::syncRoles()` | `static` |
| Exception factory methods | `static` (was `self`) |
| `PermissionRegistrar::setPermissionClass()` | `static` |
| `PermissionRegistrar::setRoleClass()` | `static` |
| `PermissionRegistrar::forgetCachedPermissions()` | `bool` (new) |
| `Contracts\PermissionsTeamResolver::setPermissionsTeamId()` | Typed param `int\|string\|Model\|null $id` |
| `Contracts\Role::hasPermissionTo()` | Typed param + optional `$guardName` |

### 7. Wildcard Contract Change

The `__construct(Model $record)` method has been **removed** from the `Spatie\Permission\Contracts\Wildcard` interface. If you implement this contract, remove the constructor from the interface requirement (your concrete class should still accept a `Model` in its constructor).

### 8. Code Modernization (Internal)

The following internal changes were made (no action needed unless you extended):
- `is_a($this, X::class)` → `$this instanceof X`
- `get_class($obj)` → `$obj::class`
- `strpos($x, $y) !== false` → `str_contains($x, $y)`
- Constructor promotion in `WildcardPermission`
- Proper `use` imports for global classes
- Migration stubs modernized
- Test suite converted from PHPUnit to Pest

---

## New Features in v7

See the [new-features.md](./new-features.md) file for details on:
- Events system for role/permission changes
- BackedEnum support in most methods
- Artisan `permission:assign-role` command
- Type-safety improvements

---

## Migration Checklist

- [ ] Update `composer.json` to `^7.0` and run `composer update spatie/laravel-permission`
- [ ] Re-publish and re-customize `config/permission.php`
- [ ] Check migration files for changes
- [ ] Update any event listeners referencing old event class names (add `Event` suffix)
- [ ] Update any references to command classes (add `Command` suffix)
- [ ] Replace `clearClassPermissions()` with `clearPermissionsCollection()` if used
- [ ] Update any extended trait methods to match new return types
- [ ] Check `Wildcard` contract implementations if applicable
- [ ] Remove Lumen-specific code if applicable
- [ ] Clear config cache: `php artisan optimize:clear`
- [ ] Run `php artisan migrate`
- [ ] Test the application thoroughly
