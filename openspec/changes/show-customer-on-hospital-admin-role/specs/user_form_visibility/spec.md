# Spec: User Form Visibility

## MODIFIED Requirements

### Requirement: Conditional Customer Selection
The User creation and edit forms MUST conditionally display a Customer selection field based on the assigned roles.

#### Scenario: Hospital Admin Role Selection
- **Given** I am on the User creation or edit form
- **When** I select the "Hospital Admin" role
- **Then** the "Customer" field must become visible
- **And** the "Customer" field must be marked as required

#### Scenario: Other Role Selection
- **Given** I am on the User creation or edit form
- **When** I select any role other than "Hospital Admin" (and "Hospital Admin" is not among the selections)
- **Then** the "Customer" field must be hidden
- **And** the "Customer" field must not be required
