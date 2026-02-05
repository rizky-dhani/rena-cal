# Tasks: Synchronize Calibration Label Layouts

## 1. Design & CSS Refinement
- [ ] 1.1 Review and unify base CSS styles for the table-based layout.
- [ ] 1.2 Update size-specific overrides for `v2` (6x4cm).
- [ ] 1.3 Update size-specific overrides for `v3` (5x3cm).
- [ ] 1.4 Update size-specific overrides for `v4` (3x1.5cm).
- [ ] 1.5 Verify consistent vertical centering across all sizes.

## 2. Verification
- [ ] 2.1 Render all 4 sizes via the `qr-print` route logic (can use the previously created logic or mock it).
- [ ] 2.2 Compare visual output against the approved `v1` design.
- [ ] 2.3 Run `vendor/bin/pint` to ensure code style compliance.
