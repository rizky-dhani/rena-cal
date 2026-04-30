---
source: Filament Official Docs + GitHub Releases
library: Filament
package: filament/filament
topic: Filament 4.x to 5.x Upgrade Guide
fetched: 2026-04-30T00:00:00Z
official_docs: https://filamentphp.com/docs/5.x/upgrade-guide
---

# Filament 4.x → 5.x Upgrade Guide

## Overview

Filament 5.x was released on January 16, 2026 (v5.0.0). This guide covers all known breaking changes, new requirements, deprecated features, and upgrade steps. The upgrade from 4.x to 5.x is significantly less disruptive than the 3.x → 4.x upgrade.

**Current latest version:** v5.6.1 (as of April 24, 2026)

---

## 1. New Requirements

| Requirement | Filament 4.x | Filament 5.x |
|-------------|-------------|-------------|
| **PHP** | 8.1+ | **8.2+** |
| **Laravel** | v10.x+ | **v11.28+** |
| **Livewire** | v3.x | **v4.0+** |
| **Tailwind CSS** | v3.x | **v4.0+** (panel builder: v4.1+) |
| **doctrine/dbal** | optional | Still optional, but no longer required by Filament |

---

## 2. Automated Upgrade Script

The primary upgrade path is running the automated upgrade script:

```bash
# Step 1: Install the upgrade helper
composer require filament/upgrade:"^5.0" -W --dev

# Step 2: Run the upgrade script
vendor/bin/filament-v5

# Step 3: Follow the instructions output by the script
# (They will be unique to your app)
composer require filament/filament:"^5.0" -W --no-update
composer update

# Step 4: Remove the upgrade helper
composer remove filament/upgrade --dev
```

> **Windows PowerShell note:** Use `~5.0` instead of `^5.0` since PowerShell ignores `^` characters:
> ```bash
> composer require filament/upgrade:"~5.0" -W --dev
> ```

**Important:** The upgrade script handles many small changes but DOES NOT handle all breaking changes. You should still review the manual steps below.

---

## 3. Plugin Compatibility

Some plugins you're using may not be available in v5 yet. Options:
- Temporarily remove them from `composer.json` until upgraded
- Replace with v5-compatible alternatives
- Wait for plugin authors to upgrade before upgrading your app
- Write PRs to help plugin authors upgrade

---

## 4. Livewire v3 → v4 Upgrade (CRITICAL)

This is the **most impactful** dependency change. Filament v5 requires Livewire v4.0+. You must upgrade your Livewire code following the [Livewire v4 upgrade guide](https://livewire.laravel.com/docs/4.x/upgrading).

### Key Livewire v3 → v4 Breaking Changes:

#### 4.1 Config File Updates

```php
// Before (v3)
'layout' => 'components.layouts.app',
'lazy_placeholder' => 'livewire.placeholder',

// After (v4)
'component_layout' => 'layouts::app',
'component_placeholder' => 'livewire.placeholder',
```

New defaults: `smart_wire_keys` now defaults to `true`.

#### 4.2 Routing Changes

```php
// Before (v3) - still works but not recommended
Route::get('/dashboard', Dashboard::class);

// After (v4) - recommended
Route::livewire('/dashboard', Dashboard::class);
```

#### 4.3 wire:model Now Ignores Child Events by Default

`wire:model` now only listens for events on the element itself (like `.self`). If you relied on bubbling from child elements, add `.deep`:

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

#### 4.4 wire:model Modifier Behavior Change

Modifiers like `.blur` and `.change` now control client-side state sync timing, not just network requests:

```blade
<!-- v3 behavior -->
<input wire:model.blur="title">

<!-- v4 equivalent -->
<input wire:model.live.blur="title">
```

#### 4.5 Component Tags Must Be Closed

```blade
<!-- Before (v3) - unclosed tag -->
<livewire:component-name>

<!-- After (v4) - self-closing tag -->
<livewire:component-name />
```

#### 4.6 wire:transition Now Uses View Transitions API

Modifiers on `wire:transition` (`.opacity`, `.scale`, `.duration.200ms`, `.origin.top`) are **no longer supported**.

#### 4.7 Livewire URL Prefix Changed

All Livewire URLs now include a unique hash from your `APP_KEY`:

```
# v3                          # v4
/livewire/update        →     /livewire-{hash}/update
/livewire/livewire.js   →     /livewire-{hash}/livewire.js
```

Update firewall rules, CDN config, or middleware that reference `/livewire/` paths.

#### 4.8 Wire:navigate:scroll

```blade
<!-- Before (v3) -->
<div wire:scroll>

<!-- After (v4) -->
<div wire:navigate:scroll>
```

#### 4.9 Method Signature Changes

Streaming method parameter order changed:

```php
// Before (v3)
$this->stream(to: '#container', content: 'Hello', replace: true);

// After (v4)
$this->stream(content: 'Hello', replace: true, el: '#container');
```

---

## 5. Tailwind CSS v3 → v4 Upgrade

Filament 5.x requires Tailwind CSS v4.0+ (v4.1+ for panel builder). The `tailwind.config.js` file is no longer used - configuration is now defined in CSS.

### 5.1 Custom Theme Changes

**Before (Tailwind v3):**
```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';

@config 'tailwind.config.js';
```

**After (Tailwind v4):**
```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';

@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
```

The `@source` entries tell Tailwind where to find classes. Check old `content` paths in `tailwind.config.js` and add them as `@source` entries.

### 5.2 Run the Tailwind Upgrade Tool

```bash
npx @tailwindcss/upgrade
```

This automatically adjusts config files for Tailwind v4 and installs Tailwind v4 packages.

### 5.3 Vite Configuration

Filament 5 uses `@tailwindcss/vite` plugin instead of `tailwindcss` PostCSS plugin:

```js
// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true }),
        tailwindcss(),
    ],
})
```

### 5.4 CSS Configuration for Tailwind v4

```css
/* resources/css/app.css */
@import 'tailwindcss';

/* Filament component imports */
@import '../../vendor/filament/support/resources/css/index.css';
/* Add other imports as needed... */

@variant dark (&:where(.dark, .dark *));
```

### 5.5 Theme Compilation

```bash
php artisan make:filament-theme
npm run build
```

---

## 6. CSS Changes for Panel Themes

### 6.1 Tailwind Classes No Longer Available Without Custom Theme

In v4, Filament's Tailwind classes were in Blade views. In v5 (continuing from v4), those classes are in CSS files using `@apply`. If you used Tailwind classes from Filament in your own code without a custom theme, you need to create one:

```bash
php artisan make:filament-theme
```

### 6.2 Theme CSS Updates

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';

/* Add @source for all directories where you use Tailwind classes */
@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
@source '../../../../resources/views/components/**/*';
@source '../../../../resources/views/livewire/**/*';
```

---

## 7. Panel Configuration Changes

### 7.1 New Package: filament/schemas

Filament 5 introduces a `filament/schemas` package (separated from forms/tables). The Schema components include Sections, Tabs, Wizards, Grids, Fieldsets, Callouts, and more.

### 7.2 Vite Theme Registration

```php
// In your PanelProvider
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->viteTheme('resources/css/filament/admin/theme.css');
}
```

### 7.3 Color System Now Uses OKLCH

Colors can be defined using OKLCH color space:

```php
$panel->colors([
    'primary' => [
        50 => 'oklch(0.969 0.015 12.422)',
        100 => 'oklch(0.941 0.03 12.58)',
        // ...
    ],
]);
```

### 7.4 Font Provider Changes

Can now specify font provider explicitly:

```php
use Filament\FontProviders\GoogleFontProvider;
use Filament\FontProviders\LocalFontProvider;

$panel->font('Inter', provider: GoogleFontProvider::class);
$panel->font('Inter', url: asset('css/fonts.css'), provider: LocalFontProvider::class);
```

---

## 8. New Features in Filament 5.x

### 8.1 AI Documentation & Filament Blueprint
- New AI-assisted development features documented at `/docs/introduction/ai`
- Filament Blueprint support

### 8.2 Async Requests
- New async request handling for better performance
- Non-blocking operation support

### 8.3 Enhanced Theme System
- `php artisan make:filament-theme` command
- Better Vite integration with `->viteTheme()`
- Tailwind v4 `@source` directive support

### 8.4 Livewire v4 Features
- Async actions via `#[Async]` attribute and `.async` modifier
- Islands (isolated component regions)
- Single-file components
- Deferred loading
- New directives: `wire:sort`, `wire:intersect`, `wire:ref`

---

## 9. Version Support Policy

| Version | New Features | Bug Fixes | Security Fixes |
|---------|-------------|-----------|----------------|
| 4.x | ✅ Ended | ✅ until Jan 15, 2027 | ✅ until Jan 15, 2028 |
| 5.x | ✅ until 6.x stable | ✅ ~1 year after 6.x | ✅ ~2 years after 6.x |

---

## 10. Quick Upgrade Checklist

- [ ] Verify PHP 8.2+ is available
- [ ] Upgrade to Laravel v11.28+
- [ ] Back up your project (git commit all changes)
- [ ] Run `composer require filament/upgrade:"^5.0" -W --dev`
- [ ] Run `vendor/bin/filament-v5` and follow instructions
- [ ] Run the upgrade commands output by the script
- [ ] Update Composer: `composer require filament/filament:"^5.0" -W --no-update && composer update`
- [ ] Remove upgrade helper: `composer remove filament/upgrade --dev`
- [ ] Upgrade Livewire: `composer require livewire/livewire:^4.0`
- [ ] Follow the Livewire v3→v4 upgrade guide
- [ ] Upgrade Tailwind CSS: `npx @tailwindcss/upgrade`
- [ ] If using a custom theme, update CSS for Tailwind v4
- [ ] Check plugin compatibility - remove incompatible plugins temporarily
- [ ] Run `php artisan optimize:clear`
- [ ] Test all panel functionality thoroughly
- [ ] Check for deprecated method usage in custom code

---

## 11. Official Documentation Links

- **Filament 5.x Upgrade Guide:** https://filamentphp.com/docs/5.x/upgrade-guide
- **Filament 5.x Installation:** https://filamentphp.com/docs/5.x/introduction/installation
- **Livewire v4 Upgrade Guide:** https://livewire.laravel.com/docs/4.x/upgrading
- **Tailwind CSS v4 Upgrade Guide:** https://tailwindcss.com/docs/upgrade-guide
- **Filament GitHub Releases:** https://github.com/filamentphp/filament/releases
