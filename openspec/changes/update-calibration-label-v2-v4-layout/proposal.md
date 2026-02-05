# Change: Synchronize Calibration Label Layouts

## Why
The `v1` calibration label layout has been finalized and approved. Currently, the `v2`, `v3`, and `v4` layouts slightly differ in their structural approach or scaling ratios. Synchronizing them with the `v1` design ensures a consistent brand identity and professional look across all label sizes.

## What Changes
- Update CSS for `v2`, `v3`, and `v4` to match the `v1` structural pattern (logo in its own row, two-column details/barcode section).
- Ensure proportional scaling for fonts, boxes, and images across all versions.
- Maintain existing physical dimensions for each variant.

## Impact
- Affected specs: `calibration_label`
- Affected code: `resources/views/pdf/asset-calibration-labels.blade.php`
