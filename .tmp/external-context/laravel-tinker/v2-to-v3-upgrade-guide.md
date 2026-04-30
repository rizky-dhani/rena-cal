---
source: GitHub Releases & PRs
library: laravel/tinker
package: laravel/tinker
topic: v2 to v3 Upgrade Guide
fetched: 2026-04-30T06:03:00Z
official_docs: https://github.com/laravel/tinker
---

# laravel/tinker v2 → v3 Upgrade Guide

**Release Date:** March 17, 2026
**Latest v3 Version:** v3.0.2 (April 14, 2026)
**Repository:** https://github.com/laravel/tinker
**Packagist:** https://packagist.org/packages/laravel/tinker

---

## Breaking Changes Summary

### 1. PHP Version Requirement Increased

|            | v2.x               | v3.x    |
|------------|--------------------|---------|
| **PHP**    | `^7.2.5 \| ^8.0`  | `^8.1`  |

**Action:** You must be running PHP 8.1 or higher. PHP 7.x and PHP 8.0 are no longer supported.

---

### 2. Laravel / Illuminate Version Support Dropped & Extended

| Requirement              | v2.x                                                       | v3.x                                                           |
|--------------------------|------------------------------------------------------------|----------------------------------------------------------------|
| `illuminate/console`     | `^6.0 \| ^7.0 \| ^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0` | `^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0 \| ^13.0`            |
| `illuminate/contracts`   | `^6.0 \| ^7.0 \| ^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0` | `^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0 \| ^13.0`            |
| `illuminate/support`     | `^6.0 \| ^7.0 \| ^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0` | `^8.0 \| ^9.0 \| ^10.0 \| ^11.0 \| ^12.0 \| ^13.0`            |

- **Dropped:** Laravel 6.x and 7.x support
- **Added:** Laravel 13.x support

**Action:** You must be on Laravel 8.0 or higher. If you're on Laravel 6.x or 7.x, you must upgrade Laravel first.

---

### 3. PsySH Dependency Updated

|          | v2.x                        | v3.x          |
|----------|-----------------------------|---------------|
| **psy/psysh** | `^0.11.1 \| ^0.12.0`       | `^0.12.0`     |

**Action:** PsySH v0.11.x is no longer supported. The minimum required version is now psy/psysh `^0.12.0`.

---

### 4. Symfony VarDumper Minimum Version Increased

|                       | v2.x                                         | v3.x                             |
|-----------------------|----------------------------------------------|----------------------------------|
| **symfony/var-dumper** | `^4.3.4 \| ^5.0 \| ^6.0 \| ^7.0 \| ^8.0`   | `^5.4 \| ^6.0 \| ^7.0 \| ^8.0`  |

**Action:** Symfony VarDumper v4.x is no longer supported. Minimum version is now `^5.4`.

---

### 5. --execute Option Now Returns Correct Exit Code on Exceptions

**PR:** [#165](https://github.com/laravel/tinker/pull/165)

The `--execute` (`-e`) option behavior has changed:

- **Before (v2.x):** When executing code via `php artisan tinker --execute "..."`, all exceptions were caught and rendered by PsySH internally. The command always returned exit code 0, making it impossible to determine if the executed code failed.
- **After (v3.x):** When an exception is thrown during `--execute`, the command now returns **exit code 1**.

**Migration:** If you have scripts or CI pipelines that use `php artisan tinker --execute` and check the exit code, be aware that failures will now correctly signal as non-zero exit codes.

---

### 6. PsySH "Trust Project" Prompt Now Avoided by Default

**PR:** [#198](https://github.com/laravel/tinker/pull/198)

A new configuration setting has been introduced to avoid the PsySH "Do you trust this project?" interactive prompt that could block non-interactive Tinker usage.

A new config option (likely `'trust_project'` or similar in `config/tinker.php`) controls this behavior. By default, the trust prompt is now suppressed.

**Migration:** If you relied on the PsySH trust prompt for security, you can opt back in via the Tinker config file (publish with `php artisan vendor:publish --provider="Laravel\Tinker\TinkerServiceProvider"`).

---

## New Features

### Laravel 13 Support

**PR:** [#197](https://github.com/laravel/tinker/pull/197)

Tinker v3 now supports Laravel 13.

---

## Dev Dependency Changes

| Package          | v2.x                                 | v3.x                  |
|------------------|--------------------------------------|-----------------------|
| **phpunit/phpunit** | `^8.5.8 \| ^9.3.3 \| ^10.0`        | `^10.5 \| ^11.5`      |

---

## Quick Migration Steps

1. **Update PHP** to 8.1 or higher
2. **Update Laravel** to 8.0 or higher (preferably latest stable)
3. **Update composer dependency:**
   ```bash
   composer require laravel/tinker:^3.0
   ```
4. **Review `--execute` usage** in scripts/CI — exit code 1 on exceptions is now correct behavior
5. **Publish config** if needed:
   ```bash
   php artisan vendor:publish --provider="Laravel\Tinker\TinkerServiceProvider"
   ```

---

## Links

- **GitHub Releases:** https://github.com/laravel/tinker/releases
- **v3.0.0 Release:** https://github.com/laravel/tinker/releases/tag/v3.0.0
- **Full Changelog v3.0.0 → v3.0.2:** https://github.com/laravel/tinker/compare/v3.0.0...v3.0.2
- **Packagist:** https://packagist.org/packages/laravel/tinker
