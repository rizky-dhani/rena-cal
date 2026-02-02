# Proposal: Add Status Selection to Generate Empty QR

This proposal adds a "Status" (Result) selection to the "Generate Empty QR" action in the Devices resource. This allows users to pre-define whether the generated empty QR codes are for devices that are "Laik Pakai" (Fit For Use) or "Tidak Laik Pakai" (Not Fit For Use).

## Problem
Currently, generating empty QR codes creates device records with a `null` result (status). Users have to manually edit each device or use bulk actions later to set the status. By adding this selection to the generation process, we streamline the workflow for creating QR codes for specific status groups.

## Solution
1.  **Update `ListDevices.php`**: Add a `Select` component for the `result` field to the `generate_empty_qr` header action.
2.  **Pass Data**: Ensure the selected `result` is passed into the `GenerateMultipleQRCodesJob`.
3.  **Update Job**: Modify `GenerateMultipleQRCodesJob` to include the `result` when inserting new device records.

## Scope
- `app/Filament/Dashboard/Resources/Devices/Pages/ListDevices.php`: Modify the action form and dispatch logic.
- `app/Jobs/GenerateMultipleQRCodesJob.php`: Update the handle method to save the result.
