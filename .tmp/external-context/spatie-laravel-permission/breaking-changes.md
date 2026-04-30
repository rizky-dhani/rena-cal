---
source: Spatie Official Docs + Context7 API
library: spatie/laravel-permission
package: spatie/laravel-permission
topic: Breaking Changes from v6 to v7
fetched: 2026-04-30T12:00:00Z
official_docs: https://spatie.be/docs/laravel-permission/v7/upgrading
---

# Breaking Changes: spatie/laravel-permission v6 → v7

## Summary

| # | Breaking Change | Impact |
|---|-----------------|--------|
| 1 | PHP 8.3+ required (was PHP 8.0+) | Must upgrade PHP |
| 2 | Laravel 12+ required (was Laravel 10+) | Must upgrade Laravel |
| 3 | Lumen support removed | Must migrate from Lumen |
| 4 | Service Provider changed to `PackageServiceProvider` | Affects extended providers |
| 5 | Event classes renamed with `Event` suffix | Affects event listeners |
| 6 | Command classes renamed with `Command` suffix | Affects command references |
| 7 | `clearClassPermissions()` removed | Replace with `clearPermissionsCollection()` |
| 8 | Added return types to traits/contracts | Breaks extended classes |
| 9 | `Wildcard` contract constructor removed | Affects Wildcard implementations |
| 10 | `forgetCachedPermissions()` now returns `bool` | May affect code relying on void return |

---

## Breaking Change Details

### 1. PHP Version Requirement
- **Old**: PHP ^8.0
- **New**: PHP ^8.3 (v7.0 originally required ^8.4, relaxed to ^8.3 in v7.3.0)
- **Action**: Upgrade PHP to 8.3+

### 2. Laravel Version Requirement
- **Old**: Laravel ^10.0+
- **New**: Laravel ^12.0+
- **Action**: Upgrade Laravel to 12+

### 3. Lumen Support Removed
- **Old**: Lumen was supported (separate installation guide)
- **New**: Lumen support completely removed
- **Action**: Migrate from Lumen to Laravel, or stay on v6

### 4. Service Provider Change
- **Old**: Extended `Illuminate\Support\ServiceProvider`
- **New**: Extends `Spatie\PackageTools\PackageServiceProvider` from `spatie/laravel-package-tools`
- **Action**: If you manually registered or extended the service provider, update your code

### 5. Event Class Renames
All event classes must be updated in listeners:
- `PermissionAttached` → `PermissionAttachedEvent`
- `PermissionDetached` → `PermissionDetachedEvent`
- `RoleAttached` → `RoleAttachedEvent`
- `RoleDetached` → `RoleDetachedEvent`

### 6. Command Class Renames
All artisan command classes renamed:
- `CacheReset` → `CacheResetCommand`
- `CreateRole` → `CreateRoleCommand`
- `CreatePermission` → `CreatePermissionCommand`
- `Show` → `ShowCommand`
- `UpgradeForTeams` → `UpgradeForTeamsCommand`
- `AssignRole` → `AssignRoleCommand`

Artisan command signatures (the string you type) remain unchanged.

### 7. Removed Method: `clearClassPermissions()`
- **Old**: `PermissionRegistrar::clearClassPermissions()`
- **Replacement**: `PermissionRegistrar::clearPermissionsCollection()`
- **Action**: Search and replace all usages

### 8. Stricter Return Types on Traits
If you extended any of these traits and overrode these methods, update signatures:

```php
// HasPermissions trait
public function givePermissionTo(...): static  // was mixed
public function syncPermissions(...): static   // was mixed  
public function revokePermissionTo(...): static // was mixed

// HasRoles trait
public function assignRole(...): static  // was $this
public function removeRole(...): static  // was $this/null
public function syncRoles(...): static   // was $this
```

### 9. Wildcard Contract Change
- **Old**: `Wildcard` interface had `__construct(Model $record)`
- **New**: Constructor removed from interface
- **Action**: Remove constructor from `implements Wildcard` declarations

### 10. `forgetCachedPermissions()` Now Returns `bool`
- **Old**: Returned `void`
- **New**: Returns `bool` (true on success)
- **Action**: If you overrode this, update return type

---

## Common Migration Errors

### Error: "Access to undeclared static property"
```
Error: Access to undeclared static property Spatie\Permission\PermissionRegistrar::$pivotPermission
```
**Cause**: Migration file needs upgrading to anonymous-class syntax (Laravel 8+).
**Fix**: Re-publish migrations or update them to use the new stub format.

### Error: Class not found for event/command
```
Class "Spatie\Permission\Events\PermissionAttached" not found
```
**Cause**: Event classes were renamed.
**Fix**: Update to `PermissionAttachedEvent`.

### Error: "There is no permission named '123'"
```
There is no permission named '123' for guard 'web'
```
**Note**: This is from the v5→v6 upgrade, not v6→v7. Included for reference.
**Cause**: Passing integer IDs as strings from HTML forms.
**Fix**: Cast IDs to integers: `collect($validated['permission'])->map(fn($val)=>(int)$val)`
