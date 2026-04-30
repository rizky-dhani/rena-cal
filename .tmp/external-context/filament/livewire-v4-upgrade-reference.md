---
source: Livewire Official Docs
library: Livewire
package: livewire/livewire
topic: Livewire v3 to v4 Upgrade Reference for Filament 5
fetched: 2026-04-30T00:00:00Z
official_docs: https://livewire.laravel.com/docs/4.x/upgrading
---

# Livewire v3 → v4 Upgrade Reference

**Required by:** Filament 5.x

This is a condensed reference of all breaking changes, renames, and new requirements when upgrading from Livewire v3 to v4. This upgrade is mandatory for Filament 4.x → 5.x migration.

---

## Installation

```bash
composer require livewire/livewire:^4.0
php artisan optimize:clear
```

---

## 1. Config File Changes

### Renamed Keys

```php
// Before (v3)
'layout' => 'components.layouts.app',
'lazy_placeholder' => 'livewire.placeholder',

// After (v4)
'component_layout' => 'layouts::app',
'component_placeholder' => 'livewire.placeholder',
```

### Changed Defaults

```php
// v4 defaults to true (was false in v3)
'smart_wire_keys' => true,
```

### New Configuration Options

```php
// Component locations for single-file and multi-file components
'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],

// Component namespaces for view-based components
'component_namespaces' => [
    'layouts' => resource_path('views/layouts'),
    'pages' => resource_path('views/pages'),
],

// Make command defaults
'make_command' => [
    'type' => 'sfc',  // Options: 'sfc', 'mfc', or 'class'
    'emoji' => true,
],

// CSP-safe mode (new)
'csp_safe' => false,
```

---

## 2. Routing Changes

**Recommended approach for full-page components:**

```php
// Before (v3) - still works but not recommended
Route::get('/dashboard', Dashboard::class);

// After (v4) - required for single-file/multi-file components
Route::livewire('/dashboard', Dashboard::class);

// For view-based components:
Route::livewire('/dashboard', 'pages::dashboard');
```

---

## 3. wire:model Behavior Changes

### 3.1 Now Ignores Child Events by Default

`wire:model` now only listens for events on the element itself (equivalent to `.self`). To listen for bubbling from child elements, add `.deep`:

```blade
<!-- Before: listened to child events by default -->
<div wire:model="value">
    <input type="text">
</div>

<!-- After: add .deep to restore old behavior -->
<div wire:model.deep="value">
    <input type="text">
</div>
```

### 3.2 Modifiers Control Client-Side Sync Timing

`.blur` and `.change` now control when client-side state syncs, not just network timing:

| v3 Syntax | v4 Equivalent |
|-----------|---------------|
| `wire:model.blur` | `wire:model.live.blur` |
| `wire:model.change` | `wire:model.live.change` |
| `wire:model.lazy` | No change needed (backward compatible) |

**New v4 patterns:**
```blade
<!-- Only update $wire.width when user tabs away -->
<input wire:model.blur="width">

<!-- Update on Enter key or blur -->
<input wire:model.blur.enter="search">
```

---

## 4. Template Directive Changes

### 4.1 Component Tags Must Be Closed

```blade
<!-- Before (v3) - may render, unclosed -->
<livewire:component-name>

<!-- After (v4) - must be self-closing -->
<livewire:component-name />
```

### 4.2 wire:navigate:scroll

```blade
<!-- Before (v3) -->
<div wire:scroll>

<!-- After (v4) -->
<div wire:navigate:scroll>
```

### 4.3 wire:transition Uses View Transitions API

Basic usage still works, but **all modifiers are removed**:

```blade
<!-- This still works -->
<div wire:transition>...</div>

<!-- These NO LONGER work -->
<div wire:transition.opacity>...</div>
<div wire:transition.scale.origin.top>...</div>
<div wire:transition.duration.500ms>...</div>
```

---

## 5. Method Signature Changes

### 5.1 Streaming

```php
// Before (v3)
$this->stream(to: '#container', content: 'Hello', replace: true);

// After (v4)
$this->stream(content: 'Hello', replace: true, el: '#container');
```

### 5.2 Component Mounting (internal)

```php
// Before (v3)
public function mount($name, $params = [], $key = null)

// After (v4)
public function mount($name, $params = [], $key = null, $slots = [])
```

---

## 6. URL Changes

All Livewire URLs now include a unique hash from your `APP_KEY`:

```
# v3                          # v4
/livewire/update        →     /livewire-{hash}/update
/livewire/upload-file   →     /livewire-{hash}/upload-file
/livewire/livewire.js   →     /livewire-{hash}/livewire.js
```

If using `setUpdateRoute`:

```php
// Before (v3)
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

// After (v4)
Livewire::setUpdateRoute(function ($handle, $path) {
    return Route::post($path, $handle);
});
```

---

## 7. JavaScript Deprecations

### 7.1 `$wire.$js()` Method (deprecated)

```javascript
// Deprecated (v3)
$wire.$js('bookmark', () => {
    // Toggle bookmark...
});

// New (v4)
$wire.$js.bookmark = () => {
    // Toggle bookmark...
};
```

### 7.2 `$js` Without Prefix (deprecated)

```javascript
// Deprecated
$js('bookmark', () => { ... });

// New
$wire.$js.bookmark = () => { ... };
// or
this.$js.bookmark = () => { ... };
```

### 7.3 `commit` and `request` Hooks (deprecated)

Replace `Livewire.hook('commit', ...)` with `Livewire.interceptMessage(...)`.
Replace `Livewire.hook('request', ...)` with `Livewire.interceptRequest(...)`.

---

## 8. New Livewire v4 Features

- **Single-file and multi-file components** (new `php artisan make:livewire` format)
- **Slots and attribute forwarding** in components
- **Islands** - isolated regions that update independently (`@island`)
- **Deferred loading** (`#[Defer]` attribute, `defer` modifier)
- **Bundled loading** (`lazy.bundle`, `defer.bundle` modifiers)
- **Async actions** (`#[Async]` attribute, `.async` modifier)
- **`wire:sort`** - drag-and-drop sorting
- **`wire:intersect`** - viewport intersection
- **`wire:ref`** - element references
- **`.renderless` modifier** - skip re-rendering
- **`.preserve-scroll` modifier** - preserve scroll position
- **`data-loading` attribute** - auto-applied to elements triggering requests
- **`$errors` magic property** - access error bag from JavaScript
- **`$intercept` magic** - intercept Livewire requests from JavaScript

---

## 9. Volt Users (if migrating from Livewire Volt)

If you were using the `livewire/volt` package:

1. **Replace imports:** `Livewire\Volt\Component` → `Livewire\Component`
2. **Replace routes:** `Volt::route()` → `Route::livewire()`
3. **Replace tests:** `Volt::test()` → `Livewire::test()`
4. **Remove Volt service provider** from `bootstrap/providers.php`
5. **Remove package:** `composer remove livewire/volt`
