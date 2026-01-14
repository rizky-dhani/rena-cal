# Specification: Bahasa Indonesia Localization & Secure Customer Portal

## Overview
This track aims to provide a fully localized experience in Bahasa Indonesia across the entire Rena Calibration platform and to introduce a secure portal where customers can manage and track their specific assets.

## User Stories
- **As an Admin/Technician:** I want the dashboard and all its functions to be in Bahasa Indonesia so I can work more efficiently.
- **As a Customer:** I want to log in to a secure portal in my native language to see the status of all my devices in one place.
- **As a Developer:** I want a standardized way to handle translations so that new features can be easily localized.

## Technical Requirements
- **Localization:**
    - Use Laravel's translation files (`lang/id/`).
    - Ensure all Filament resources, pages, and actions use the `->label()` and `->translateLabel()` methods correctly.
    - Localize generated PDFs and Excel exports.
- **Customer Portal:**
    - Implement a new Filament Panel or a dedicated route/Livewire component for customers.
    - Use `spatie/laravel-permission` to define a "Customer" role.
    - Implement scoping (Global Scopes or Query Builder filters) to ensure customers only see assets belonging to their `customer_id`.
    - Secure the portal with standard Laravel authentication.

## Acceptance Criteria
- 100% of the UI seen by a Customer is in Bahasa Indonesia.
- 100% of the UI seen by a Technician/Admin is in Bahasa Indonesia.
- A user with the "Customer" role can log in and view *only* their assets.
- All validation messages are in Bahasa Indonesia.
