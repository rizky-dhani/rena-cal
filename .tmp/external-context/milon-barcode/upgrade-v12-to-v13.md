---
source: GitHub (milon/barcode releases & commits)
library: milon/barcode
package: milon/barcode
topic: v12 to v13 upgrade guide
fetched: 2026-04-30T00:00:00Z
official_docs: https://github.com/milon/barcode
---

# milon/barcode: v12 → v13 Upgrade Guide

## Overview

Version 13.0 was released on **February 24, 2026**. The primary purpose of this release is to add **Laravel 13.x compatibility**. There are no breaking API changes to the barcode generation methods themselves, but several important fixes and improvements are included.

Version 13.1 (also February 24, 2026) followed shortly after and added tests and CI infrastructure without any further API changes.

## At a Glance: Should You Upgrade?

| Consideration | Decision |
|---|---|
| Running Laravel 13? | **Yes, upgrade to ^13.0** |
| Running Laravel 12 or below? | **Still compatible with ^12.0** — upgrade optional |
| Need background color on 2D PNG barcodes? | **Upgrade — new feature** |
| Seeing QR code precision notices? | **Upgrade — bugfix included** |

## Version Table

| Laravel Version | Barcode Package Version |
|---|---|
| 13.* | ^13.0 |
| 12.* | ^12.0 |
| 11.* | ^11.0 |
| 10.* | ^10.0 |
| 9.* | ^9.0 |
| 8.* | ^8.0 |
| 7.* | ^7.0 |
| 6.* | ^6.0 |
| 5.0-5.1 | ^5.1 |
| 4.0-4.2 | ^4.2 |

---

## All Changes from v12.0.0 → v13.0

### 1. Composer Dependency Change (The Major Bump)

**File:** `composer.json`

**v12.0.0:**
```json
"illuminate/support": "^7.0|^8.0|^9.0|^10.0 | ^11.0 | ^12.0"
```

**v13.0:**
```json
"illuminate/support": "^7.0|^8.0|^9.0|^10.0 | ^11.0 | ^12.0 | ^13.0"
```

**Impact:** `illuminate/support` now also accepts `^13.0`. All earlier Laravel versions (7–12) remain supported. This is backwards compatible — no `composer.json` change needed if you are not on Laravel 13.

**Migration step (if on Laravel 13):**
```bash
composer require milon/barcode:^13.0
```

---

### 2. New Feature: Background Color Support for 2D Barcodes (DNS2D)

**Files:** `src/Milon/Barcode/DNS2D.php`, `src/Milon/Barcode/Facades/DNS2DFacade.php`

**What changed:**
Both `getBarcodePNG()` and `getBarcodePNGPath()` on `DNS2D` now accept an **optional 6th parameter `$bgcolor`**.

**New signatures:**
```php
public function getBarcodePNG(
    string $code,
    string $type,
    int $w = 3,
    int $h = 3,
    array $color = [0, 0, 0],
    ?array $bgcolor = null       // NEW: RGB array or null for transparent
): string|false
```

```php
public function getBarcodePNGPath(
    string $code,
    string $type,
    int $w = 3,
    int $h = 3,
    array $color = [0, 0, 0],
    ?array $bgcolor = null       // NEW: RGB array or null for transparent
): string|false
```

**Behavior:**

| `$bgcolor` value | Behavior |
|---|---|
| `null` (default) | Background is **transparent** (same as v12 behavior) |
| `[255, 255, 255]` | White background |
| `[255, 0, 0]` | Red background |
| Any RGB array | Solid background in that color |

**Facade docblock updated:**
```php
// v12:
@method static string|false getBarcodePNG(string $code, string $type, int $w = 3, int $h = 3, array $color = [0, 0, 0],)
@method static string|false getBarcodePNGPath(string $code, string $type, int $w = 2, int $h = 30, array $color = [0, 0, 0])

// v13:
@method static string|false getBarcodePNG(string $code, string $type, int $w = 3, int $h = 3, array $color = [0, 0, 0], ?array $bgcolor = null)
@method static string|false getBarcodePNGPath(string $code, string $type, int $w = 2, int $h = 30, array $color = [0, 0, 0], ?array $bgcolor = null)
```

**Usage examples:**
```php
// Transparent background (same as v12 default behavior)
DNS2D::getBarcodePNG('4445645656', 'QRCODE');

// Custom background color
DNS2D::getBarcodePNG('4445645656', 'QRCODE', 3, 3, [0, 0, 0], [255, 255, 255]);
DNS2D::getBarcodePNGPath('4445645656', 'PDF417', 3, 3, [0, 0, 0], [255, 255, 0]);
```

**Under-the-hood changes:**
- GD branch: Background image color now uses the provided `$bgcolor` (defaults to white `[255,255,255]`), and transparency (`imagecolortransparent`) is only set when `$bgcolor` is null.
- Imagick branch: The `newImage()` call uses `'none'` (transparent) when `$bgcolor` is null, or the provided background color when set. Also fixes the Imagick pixel string format.

**Backwards compatibility:** ✅ Fully backwards compatible. Passing no `$bgcolor` produces identical output to v12.

---

### 3. Bug Fix: QR Code "Float to int loses precision" Notice

**File:** `src/Milon/Barcode/QRcode.php`

**What changed:** Added `floor()` to array index lookups to prevent PHP notices about float-to-int implicit conversion.

**Before (v12):**
```php
$ret = $this->rsblocks[$row]['data'][$col];
$ret = $this->rsblocks[$row]['ecc'][$col];
```

**After (v13):**
```php
$ret = $this->rsblocks[floor($row)]['data'][floor($col)];
$ret = $this->rsblocks[floor($row)]['ecc'][floor($col)];
```

**Impact:** Eliminates PHP deprecation/notice warnings when generating QR codes with certain data sizes. No behavioral change.

---

### 4. Bug Fix: Imagick RGB String Typo (Missing Parenthesis)

**Files:** `src/Milon/Barcode/DNS1D.php`, `src/Milon/Barcode/DNS2D.php`

**What changed:** Fixed a typo where `'rgb(255,255,255'` was missing the closing `)`.

**Before (v12):**
```php
$bgcol = new imagickpixel('rgb(255,255,255');   // Syntax error in Imagick
```

**After (v13):**
```php
$bgcol = new imagickpixel('rgb(255,255,255)');  // Correct syntax
```

This fix was applied in 4 locations:
- `DNS1D.php` — `getBarcodePNGPath()` Imagick branch (line ~283)
- `DNS1D.php` — `getBarcodeJPGPath()` Imagick branch (line ~2739)
- `DNS2D.php` — `getBarcodePNG()` Imagick branch (line ~199)
- `DNS2D.php` — `getBarcodePNGPath()` Imagick branch (line ~291)

**Impact:** This was a real bug — the missing closing parenthesis in the Imagick pixel constructor would cause Imagick to either throw an error or produce undefined behavior when generating barcodes via the Imagick extension. Users relying on GD were not affected.

---

### 5. Documentation: Added Banner to README

**What changed:** A banner image was added to the top of the README. No functional impact.

---

## v13.0 → v13.1 Changes

Released the same day (Feb 24, 2026). **No API changes.**

| Commit | Description |
|---|---|
| ceeb814 | Added PHPUnit tests |
| bc08abb | Added GitHub Actions workflow to run tests automatically |
| ce84b0b | Added automatic release generation on tags |

`composer.json` in v13.1 also gained:
```json
"require-dev": {
    "phpunit/phpunit": "^9.5 || ^10.0"
},
"scripts": {
    "test": "phpunit"
}
```

---

## Full Commit List (v12.0.0 → v13.0)

| Date | Author | Commit | Description |
|---|---|---|---|
| Apr 30, 2025 | milon | 1d24ac6 | Added a banner in the readme |
| Jul 8, 2025 | erikn69 | 0591319 | Fix float to int loses precision notice on QR (#202) |
| Sep 30, 2025 | erikn69 | ba0f427 | Fix rgb string typo (missing parenthesis) (#204) |
| Sep 30, 2025 | erikn69 | f4fa9b8 | Support background color, transparent as default (#205) |
| Feb 7, 2026 | milon | a5c019c | Merge PR #202 |
| Feb 7, 2026 | milon | d4ad523 | Merge PR #205 |
| Feb 7, 2026 | milon | 5dbd887 | Merge branch 'master' |
| Feb 7, 2026 | milon | 052e601 | Merge PR #204 |
| Feb 20, 2026 | laravel-shift | e5400c4 | Bump dependencies for Laravel 13 (#208) |
| Feb 23, 2026 | milon | edaa9c9 | Merge PR #208 |
| Feb 24, 2026 | milon | 23d5a93 | Update readme file |

---

## Migration Guide

### Step 1: Update composer.json

```bash
# If on Laravel 13:
composer require milon/barcode:^13.0

# If on Laravel 12 or below — no composer change needed
# (^12.0 still works and v13 is backwards compatible)
```

### Step 2: Check QR Code Usage

If you were seeing PHP notices about "float to int loses precision" when generating QR codes, upgrading to v13.0 (or later) will resolve them.

### Step 3: Check Imagick Usage

If you were using the Imagick extension for barcode generation and noticing errors or broken images, the missing parenthesis fix in v13.0 will resolve the issue.

### Step 4: (Optional) Use New Background Color Feature

If you need PNG barcodes with a solid background instead of transparent:
```php
// 2D barcodes with white background:
DNS2D::getBarcodePNG('4445645656', 'QRCODE', 3, 3, [0, 0, 0], [255, 255, 255]);
DNS2D::getBarcodePNGPath('4445645656', 'PDF417', 3, 3, [0, 0, 0], [255, 255, 255]);
```

Note: Background color is **only** available on `DNS2D` (2D barcodes) in this release. `DNS1D` (1D barcodes) is unchanged.

### Step 5: Verify

```php
// Quick test to ensure everything works after upgrade:
echo DNS1D::getBarcodeHTML('4445645656', 'C39');
echo DNS2D::getBarcodeHTML('4445645656', 'QRCODE');
```

---

## Summary of Breaking Changes

**There are NO breaking changes in v13 compared to v12.** All existing APIs remain fully backwards compatible. The version bump from v12 to v13 was driven by the `illuminate/support` dependency adding Laravel 13 support, not by any API-breaking changes.

The main reasons to upgrade:
1. **Laravel 13 compatibility** (primary reason for the major version bump)
2. **QR code precision fix** (eliminates PHP notices)
3. **Imagick syntax fix** (fixes a real bug with Imagick barcode generation)
4. **New background color parameter** for 2D barcodes (optional enhancement)
