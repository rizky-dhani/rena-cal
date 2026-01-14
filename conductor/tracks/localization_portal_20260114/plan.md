# Plan: Bahasa Indonesia Localization & Secure Customer Portal

## Phase 1: Core Localization (Bahasa Indonesia)
This phase focuses on ensuring the backend and administrative interface are fully localized.

- [x] **Task: Verify and Sync Language Files**
    - [x] Write Tests: Ensure translation keys exist for core entities (Device, Brand, Location).
    - [x] Implement: Complete the `lang/id/*.php` files with missing translations.
- [ ] **Task: Localize Filament Resources**
    - [ ] Write Tests: Verify labels on `DeviceResource` reflect Indonesian translations.
    - [ ] Implement: Update all Filament resources to use `translateLabel()` or explicit localized labels.
- [ ] **Task: Localize Validation and Notifications**
    - [ ] Write Tests: Trigger a validation error and verify the message is in Indonesian.
    - [ ] Implement: Ensure `lang/id/validation.php` is complete and notifications use localized strings.
- [ ] **Task: Conductor - User Manual Verification 'Core Localization' (Protocol in workflow.md)**

## Phase 2: Secure Customer Portal Implementation
This phase implements the customer-facing dashboard with data scoping.

- [ ] **Task: Define Customer Role and Permissions**
    - [ ] Write Tests: Verify a user with 'Customer' role cannot access the main admin panel.
    - [ ] Implement: Create the 'Customer' role and assign basic view permissions.
- [ ] **Task: Implement Data Scoping for Customers**
    - [ ] Write Tests: Create assets for two different customers and verify Customer A cannot see Customer B's assets.
    - [ ] Implement: Use a Global Scope on the `Device` model or a base query in the Customer dashboard.
- [ ] **Task: Create Customer Dashboard UI**
    - [ ] Write Tests: Verify the dashboard renders correctly for a logged-in customer.
    - [ ] Implement: Build the customer-specific Filament panel or Livewire view.
- [ ] **Task: Conductor - User Manual Verification 'Secure Customer Portal' (Protocol in workflow.md)**

## Phase 3: Final Polish and Reporting
Finalizing the localized experience for all outputs.

- [ ] **Task: Localize PDF and Excel Reports**
    - [ ] Write Tests: Generate a sample report and verify headers and data labels are in Indonesian.
    - [ ] Implement: Update the PDF Blade templates and Excel Export classes.
- [ ] **Task: Conductor - User Manual Verification 'Final Polish' (Protocol in workflow.md)**
