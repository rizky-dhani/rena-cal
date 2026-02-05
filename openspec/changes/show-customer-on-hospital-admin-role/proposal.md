# Proposal: Show Customer select field when Hospital Admin role is selected

## Summary
Improve the User creation/edit form in the Filament dashboard to dynamically show and require the Customer (Hospital) selection field whenever the "Hospital Admin" role is selected.

## Motivation
Hospital Admin users must be associated with a specific Customer (Hospital) to manage that hospital's devices. Currently, the form may not correctly toggle visibility or enforcement based on the role selection, leading to potential data inconsistency.

## Scope
- Modify `App\Filament\Dashboard\Resources\Users\Schemas\UserForm`.
- Ensure the `roles` field correctly triggers visibility for the `customer_id` field.
- Verify that the `customer_id` field is required when "Hospital Admin" is selected.
