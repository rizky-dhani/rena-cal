---
source: Filament Official Docs
library: Filament
package: filament/filament
topic: Tailwind CSS v4 Theme Changes for Filament 5
fetched: 2026-04-30T00:00:00Z
official_docs: https://filamentphp.com/docs/5.x/styling/overview
---

# Tailwind CSS v4 Theme Changes for Filament 5

## Requirement

Filament 5.x requires **Tailwind CSS v4.0+** (v4.1+ for panel builder).

---

## 1. No More tailwind.config.js

Tailwind CSS v4 defines configuration in CSS instead of JavaScript. The old `tailwind.config.js` file is no longer used.

### Before (Tailwind v3 + Filament 4.x):

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@config 'tailwind.config.js';
```

### After (Tailwind v4 + Filament 5.x):

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';

@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
```

Any customization from `tailwind.config.js` must be moved to the CSS file.

---

## 2. Adding @source Directives

Add `@source` entries for all directories where you use Tailwind classes:

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';

@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
@source '../../../../resources/views/components/**/*';
@source '../../../../resources/views/livewire/**/*';
@source '../../../../app/Livewire/**/*';
```

---

## 3. Creating a New Theme

```bash
php artisan make:filament-theme
```

This command:
1. Installs required Tailwind CSS dependencies
2. Generates CSS at `resources/css/filament/{panel}/theme.css`
3. Auto-adds theme to `vite.config.js` input array
4. Auto-registers `->viteTheme()` in panel provider
5. Offers to compile with Vite

### Manual Configuration

If auto-configuration fails:

**vite.config.js:**
```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

**Panel Provider:**
```php
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->viteTheme('resources/css/filament/admin/theme.css');
}
```

---

## 4. CSS Configuration for Tailwind v4 + Filament

For projects using individual components (not panel builder):

```css
@import 'tailwindcss';

/* Required by all components */
@import '../../vendor/filament/support/resources/css/index.css';

/* Required by actions and tables */
@import '../../vendor/filament/actions/resources/css/index.css';

/* Required by actions, forms and tables */
@import '../../vendor/filament/forms/resources/css/index.css';

/* Required by actions and infolists */
@import '../../vendor/filament/infolists/resources/css/index.css';

/* Required by notifications */
@import '../../vendor/filament/notifications/resources/css/index.css';

/* Required by actions, infolists, forms, schemas and tables */
@import '../../vendor/filament/schemas/resources/css/index.css';

/* Required by tables */
@import '../../vendor/filament/tables/resources/css/index.css';

/* Required by widgets */
@import '../../vendor/filament/widgets/resources/css/index.css';

@variant dark (&:where(.dark, .dark *));
```

---

## 5. Tailwind Upgrade Tool

Run the official Tailwind upgrade tool to automatically migrate:

```bash
npx @tailwindcss/upgrade
```

This handles:
- Config migration from JS to CSS
- Package updates from v3 to v4
- Class name changes

---

## 6. Important: Custom Theme Required for Your Tailwind Classes

Filament's compiled stylesheet does NOT include arbitrary Tailwind classes. If you use Tailwind classes in your own Blade/Livewire/PHP files, you **must** create a custom theme.

Without a theme, classes like `text-primary-600`, `bg-gray-100`, `p-4` will NOT work.

---

## 7. Vite Plugin Change

| Aspect | Before (v3/v4) | After (v5) |
|--------|---------------|------------|
| Plugin | `tailwindcss` PostCSS | `@tailwindcss/vite` |
| Config | `tailwind.config.js` | CSS `@import` + `@source` |
| Import | PostCSS config | `@import 'tailwindcss'` in CSS |
