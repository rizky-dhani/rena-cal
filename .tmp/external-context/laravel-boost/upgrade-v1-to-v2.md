---
source: GitHub (laravel/boost UPGRADE.md) + GitHub Releases
library: Laravel Boost
package: laravel/boost
topic: v1 to v2 Upgrade Guide
fetched: 2026-04-30T00:00:00Z
official_docs: https://github.com/laravel/boost/blob/main/UPGRADE.md
---

# Laravel Boost: Upgrading To 2.x From 1.x

> **Note:** If you are not using custom agents or overriding Boost in any way, you should experience minimal issues while upgrading. Simply run `php artisan boost:install` after upgrading to Boost 2.x and the migration will be handled automatically.

> **Note:** If you are using external packages that add custom agents, ensure you update to versions that have support for Boost 2.x.

---

## 1. Minimum PHP Version

**PHP 8.2** is now the minimum required version.

---

## 2. Minimum Laravel Version

**Laravel 11.x** is now the minimum required version.

---

## 3. Custom Agent Changes

**PR:** [#439](https://github.com/laravel/boost/pull/439)  
**Likelihood Of Impact:** Low (only if you have custom agents)

### 3.1 Terminology and Namespace Changes

`CodeEnvironment` has been replaced with `Agent` throughout:

| Before | After |
|--------|-------|
| `CodeEnvironment` | `Agent` |
| `CodeEnvironmentsDetector` | `AgentsDetector` |
| `src/Install/CodeEnvironment/` | `src/Install/Agents/` |
| `Laravel\Boost\Install\CodeEnvironment` | `Laravel\Boost\Install\Agents` |
| `registerCodeEnvironment(string $key, string $className)` | `registerAgent(string $key, string $className)` |
| `getCodeEnvironments()` | `getAgents()` |

### 3.2 Contract Renames

| Before | After |
|--------|-------|
| `Laravel\Boost\Contracts\Agent` | `Laravel\Boost\Contracts\SupportsGuidelines` |
| `Laravel\Boost\Contracts\McpClient` | `Laravel\Boost\Contracts\SupportsMcp` |
| `Laravel\Boost\Contracts\SupportSkills` | `Laravel\Boost\Contracts\SupportsSkills` |

### 3.3 Custom Agent Migration

**Before (v1.x):**

```php
<?php

namespace App\Boost;

use Laravel\Boost\Contracts\Agent;
use Laravel\Boost\Install\CodeEnvironment\CodeEnvironment;

class MyCustomAgent extends CodeEnvironment implements Agent
{
    // ...
}
```

**After (v2.x):**

```php
<?php

namespace App\Boost;

use Laravel\Boost\Contracts\SupportsGuidelines;
use Laravel\Boost\Install\Agents\Agent;

class MyCustomAgent extends Agent implements SupportsGuidelines
{
    // ...
}
```

If your agent also supports MCP or skills, add the additional contracts:

```php
use Laravel\Boost\Contracts\SupportsMcp;
use Laravel\Boost\Contracts\SupportsSkills;

class MyCustomAgent extends Agent implements SupportsGuidelines, SupportsMcp, SupportsSkills
{
    // ...
}
```

---

## 4. Configuration File Changes

**PR:** [#439](https://github.com/laravel/boost/pull/439)  
**Likelihood Of Impact:** Low (only if you overrode `config/boost.php`)

Published configuration paths have been updated from `code_environment` to `agents`:

```diff
- config('boost.code_environment.junie.guidelines_path')
+ config('boost.agents.junie.guidelines_path')
```

This was previously undocumented, so the impact is very low.

---

## 5. Installation Command Signature Change

**PR:** [#439](https://github.com/laravel/boost/pull/439)  
**Likelihood Of Impact:** Low

The `boost:install` command flags changed from negative opt-out to positive opt-in:

```diff
- php artisan boost:install {--ignore-guidelines} {--ignore-mcp}
+ php artisan boost:install {--guidelines} {--skills} {--mcp}
```

---

## 6. New Features in v2.x (summary from v2.0.0 release)

- **Agent Skills Support** — on-demand knowledge modules for specific domains (Livewire, Pest, Inertia, etc.)
- **Refactored installation UX** — clearer interactive installer
- **`boost:add-skill` command** — add skills for third-party packages
- **`boost:update` command** — keep guidelines and skills up-to-date
- **Package priority system** — better package discovery filtering
- **Boost documentation moved to Laravel Docs** (`laravel.com/docs/boost`)

---

## Quick Migration Steps

1. Update PHP to 8.2+
2. Update Laravel to 11.x+
3. Run `composer require laravel/boost --dev` (gets 2.x)
4. Run `php artisan boost:install` (migration handled automatically)
5. If you have custom agents — migrate namespaces and contracts as shown above
6. Update any references from `code_environment` to `agents` in config
7. If calling `boost:install` programmatically, update flag names
