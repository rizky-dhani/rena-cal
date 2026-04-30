---
source: Filament Official Docs + GitHub v5.0.0 Release
library: Filament
package: filament/filament
topic: New Features in Filament 5.x
fetched: 2026-04-30T00:00:00Z
official_docs: https://filamentphp.com/docs/5.x/
---

# New Features in Filament 5.x

## 1. AI Documentation & Filament Blueprint

Filament 5 introduces AI-assisted development support:
- New AI documentation section at `/docs/introduction/ai`
- Filament Blueprint - AI-powered code generation
- Better prompts and context for AI coding assistants

## 2. Async Requests

- New async request handling system (related to Livewire v4 async support)
- Non-blocking operations for better performance
- Parallel request execution support

## 3. Refactored Livewire Component Registration

- Simplified Livewire component registration in plugins
- Cleaner architecture for plugin developers
- Backward compatible with v4 plugin structure

## 4. Enhanced Enum Support

- `UnitEnum` now allowed in `authorizeIndividualRecords()`
- Enum support in `HasAuthorization` trait
- Better backed enum locale support (`->size()` support on `Icon` component)

## 5. New Package: filament/schemas

A new `filament/schemas` package has been introduced for schema-related components:
- Sections
- Tabs
- Wizards
- Grids
- Fieldsets
- Callouts
- Empty states
- Custom components
- Prime components

## 6. Theme System Improvements

- New `php artisan make:filament-theme` command
- Vite integration via `->viteTheme()` on Panel
- `@source` directives for Tailwind v4 compatibility
- Dark mode and theme mode improvements (`defaultThemeMode()`)

## 7. Color System Updates

- OKLCH color space support
- Hex/RGB to palette generation
- New `Color` utility class with all Tailwind CSS palettes

## 8. Enhanced Notifications

- Configurable temporary URL expiry duration
- Improved notification system across multiple Livewire components

## 9. FileUpload Improvements

- Custom openable/downloadable URLs support for file uploads
- File path protection in FileUpload and RichEditor

## 10. Modal Enhancements

- Extra modal overlay attributes
- SlideOver position configuration
- Modal width enum cases for missing Tailwind options

## 11. Translation & i18n

- Enhanced translation tool
- New Estonian (et) translations
- Improved Polish, Persian, Hebrew, German translations

## 12. Loading States

- Refactored loading indicator
- Deferred badge loading for relation manager tabs
- `data-loading` attribute on all request-triggering elements

## 13. Key Features Backported to 4.x

The following features have been released simultaneously for both 4.x and 5.x:
- `ActionGroup` in `headerActions()` and `footerActions()`
- Item index in `itemLabel` on Repeater
- Configurable filters remove-all action

## Upcoming (as of v5.6.1)

- Latest version: v5.6.1 (April 24, 2026)
- Active development continues on the 5.x branch
- 4.x still receives bug fixes and security updates
