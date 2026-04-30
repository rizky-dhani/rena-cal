---
source: https://github.com/spatie/laravel-permission/blob/main/CHANGELOG.md
library: spatie/laravel-permission
package: spatie/laravel-permission
topic: Changelog for v7
fetched: 2026-04-30T12:00:00Z
official_docs: https://spatie.be/docs/laravel-permission/v7/changelog
---

# Changelog: spatie/laravel-permission v7 (Complete)

## 7.4.1 - 2026-04-29
- Fix: Do not throw from `teams()` when teams feature is disabled

## 7.4.0 - 2026-04-28
- Teams accessors in HasRolesTrait
- Add `syncModels()` method to Role model with HasModels trait
- Fix malformed Bouncer link in README

## 7.3.0 - 2026-04-07
- **Downgraded PHP requirement from ^8.4 to ^8.3**

## 7.2.4 - 2026-03-17
- Internals only (CI dependencies)

## 7.2.3 - 2026-02-23
- Update config comments to point to new v7 event class names

## 7.2.2 - 2026-02-22
- Fix: Clear wildcard permission index when assigning or removing roles

## 7.2.1 - 2026-02-21
- Add Laravel 13 support
- Upgrade to laravel/passport ^13.0

## 7.2.0 - 2026-02-18
- Fix: Do not treat string '0' as empty role/permission input

## 7.1.0 - 2026-02-14
- Bring back support for PHP 8.3

## 7.0.0 - 2026-02-11
- Requires PHP ^8.4 and Laravel ^12.0
- Service provider converted to `PackageServiceProvider` from `spatie/laravel-package-tools`
- Lumen support removed
- Event classes renamed with `Event` suffix
- Command classes renamed with `Command` suffix
- Added return types and parameter types throughout
- Removed deprecated `clearClassPermissions()` method
- Removed `__construct` from `Wildcard` contract
- Modernized migration stubs
- Converted test suite from PHPUnit to Pest
- Code modernization (PHP 8+ syntax)
