---
source: Spatie Official Docs + Context7 API
library: spatie/laravel-permission
package: spatie/laravel-permission
topic: New Features in v7
fetched: 2026-04-30T12:00:00Z
official_docs: https://spatie.be/docs/laravel-permission/v7/basic-usage/enums
---

# New Features in spatie/laravel-permission v7

## 1. Events System

Events are now available for tracking role/permission assignments. They must be enabled in `config/permission.php`:

```php
'events_enabled' => true,
```

### Available Events

| Event Class | Fires When |
|-------------|------------|
| `\Spatie\Permission\Events\RoleAttachedEvent` | A role is assigned to a user |
| `\Spatie\Permission\Events\RoleDetachedEvent` | A role is removed from a user |
| `\Spatie\Permission\Events\PermissionAttachedEvent` | A permission is assigned |
| `\Spatie\Permission\Events\PermissionDetachedEvent` | A permission is removed |

> **Note**: Events can receive the role/permission details as a model ID, an Eloquent record, or an array/collection of ids or records. Always inspect the parameter before acting on it.

## 2. BackedEnum Support (continued from v6)

v7 continues and expands `BackedEnum` support throughout the package. You can use PHP Enums to reference roles and permissions:

### Example Enum Definition
```php
namespace App\Enums;

enum RolesEnum: string
{
    case WRITER = 'writer';
    case EDITOR = 'editor';
    case USERMANAGER = 'user-manager';

    public function label(): string
    {
        return match ($this) {
            static::WRITER => 'Writers',
            static::EDITOR => 'Editors',
            static::USERMANAGER => 'User Managers',
        };
    }
}
```

### Creating Roles/Permissions with Enums
Use Laravel's `enum_value()` helper:
```php
$role = app(Role::class)->findOrCreate(enum_value(RolesEnum::WRITER), 'web');
```

### Methods Supporting BackedEnum

```php
// Role assignment
$user->assignRole(RolesEnum::WRITER);
$user->removeRole(RolesEnum::EDITOR);

// Permission assignment via role
$role->givePermissionTo(PermissionsEnum::EDITPOSTS);
$role->revokePermissionTo(PermissionsEnum::EDITPOSTS);

// Direct permission assignment
$user->givePermissionTo(PermissionsEnum::EDITPOSTS);
$user->revokePermissionTo(PermissionsEnum::EDITPOSTS);

// Permission checks
$user->hasPermissionTo(PermissionsEnum::EDITPOSTS);
$user->hasAnyPermission([PermissionsEnum::EDITPOSTS, PermissionsEnum::VIEWPOSTS]);
$user->hasDirectPermission(PermissionsEnum::EDITPOSTS);

// Role checks
$user->hasRole(RolesEnum::WRITER);
$user->hasAllRoles([RolesEnum::WRITER, RolesEnum::EDITOR]);
$user->hasExactRoles([RolesEnum::WRITER, RolesEnum::EDITOR, RolesEnum::MANAGER]);

// Blade directives
@can(enum_value(PermissionsEnum::VIEWPOSTS))
```

> **Note**: The package does NOT support using `$casts` to specify enums on the `Permission` model itself. Enums are for referencing, not casting.

## 3. New Artisan Command: `permission:assign-role`

Introduced in v6.22.0 and carried into v7:
```bash
php artisan permission:assign-role
```
Assigns a role to a user from the command line.

## 4. Type Safety Improvements

- Added strict return types and parameter types throughout
- Better IDE autocompletion
- Stricter contract adherence

## 5. Service Provider Modernization

- Uses `PackageServiceProvider` from `spatie/laravel-package-tools`
- Cleaner service provider architecture

## 6. Code Modernization (Internal)

- PHP 8+ syntax throughout (constructor promotion, `str_contains`, `match` expressions)
- Pest test suite (converted from PHPUnit)
- Modernized migration stubs

## 7. Post-v7.0 Additions

### v7.4.0 (April 2026)
- **Teams accessors in HasRolesTrait**: Better teams support in the trait
- **`syncModels()` on Role model**: New method for syncing models to roles

### v7.3.0 (April 2026)
- **PHP 8.3 support restored**: Requirement downgraded from ^8.4 to ^8.3

### v7.2.0 (Feb 2026)
- **Fix**: String '0' no longer treated as empty role/permission input

### v7.2.2 (Feb 2026)
- **Fix**: Wildcard permission index cleared when assigning/removing roles

### v7.2.1 (Feb 2026)
- **Laravel 13 support** added
- Passport ^13.0 support

### v7.4.1 (April 2026)
- **Fix**: Don't throw from `teams()` when teams feature is disabled
