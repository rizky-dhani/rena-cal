---
source: Official Laravel Docs (webfetch)
library: Laravel
topic: Release Notes 13.0 — New Features
fetched: 2026-04-30T00:00:00Z
official_docs: https://laravel.com/docs/13.x/releases
---

# Laravel 13.0 Release Notes

**Released:** March 17th, 2026
**PHP Requirement:** 8.3+
**Support:** Bug fixes until Q3 2027, Security fixes until March 17th, 2028

---

## Versioning & Support Policy

- Major releases yearly (~Q1)
- Bug fixes for 18 months, security fixes for 2 years
- Use `^13.0` version constraint in `composer.json`

## PHP Version

Laravel 13.x requires **PHP 8.3 minimum** (supports up to PHP 8.5).

---

## Major New Features

### 1. Laravel AI SDK

First-party AI SDK providing a unified API for:
- **Text generation** (LLM prompts)
- **Tool-calling agents**
- **Embeddings** generation
- **Audio** synthesis
- **Image** generation
- **Vector-store** integrations

Provider-agnostic, Laravel-native developer experience.

```php
use App\Ai\Agents\SalesCoach;

$response = SalesCoach::make()->prompt('Analyze this sales transcript...');
return (string) $response;
```

```php
use Laravel\Ai\Image;
$image = Image::of('A donut sitting on the kitchen counter')->generate();
```

```php
use Laravel\Ai\Audio;
$audio = Audio::of('I love coding with Laravel.')->generate();
```

```php
use Illuminate\Support\Str;
$embeddings = Str::of('Napa Valley has great wine.')->toEmbeddings();
```

### 2. JSON:API Resources

First-party JSON:API resources for compliant API responses:
- Resource object serialization
- Relationship inclusion
- Sparse fieldsets
- Links
- JSON:API-compliant response headers

See: https://laravel.com/docs/13.x/eloquent-resources#jsonapi-resources

### 3. Request Forgery Protection (Enhanced)

CSRF middleware renamed to `PreventRequestForgery` with origin-aware request verification using `Sec-Fetch-Site` header.

### 4. Queue Routing by Class

Define default queue/connection routing rules centrally:

```php
Queue::route(ProcessPodcast::class, connection: 'redis', queue: 'podcasts');
```

### 5. Expanded PHP Attributes

New first-party PHP attributes:
- `#[Middleware]` — controller middleware
- `#[Authorize]` — controller authorization
- `#[Tries]` — max job attempts
- `#[Backoff]` — job backoff strategy
- `#[Timeout]` — job timeout
- `#[FailOnTimeout]` — fail on timeout

Plus additional attributes across Eloquent, events, notifications, validation, testing, and resource serialization.

### 6. Cache TTL Extension (`Cache::touch`)

Extend an existing cache item's TTL without retrieving and re-storing:

```php
Cache::touch('key', 3600);
```

### 7. Semantic / Vector Search

Native vector query support with PostgreSQL + pgvector:

```php
$documents = DB::table('documents')
    ->whereVectorSimilarTo('embedding', 'Best wineries in Napa Valley')
    ->limit(10)
    ->get();
```

---

## Minimal Breaking Changes Philosophy

Laravel 13 focuses on minimizing breaking changes while delivering substantial new capabilities. Most applications can upgrade without changing much application code.

---

## Official Resources

- **Release Notes:** https://laravel.com/docs/13.x/releases
- **Upgrade Guide:** https://laravel.com/docs/13.x/upgrade
- **AI SDK Docs:** https://laravel.com/docs/13.x/ai-sdk
