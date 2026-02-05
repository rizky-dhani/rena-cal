# Design: Conditional Customer Visibility in User Form

## Architecture
The implementation utilizes Filament's reactive form system.

### Components
1. **Roles Select Field**: 
   - Uses `relationship('roles', 'name')`.
   - Marked as `reactive()` (or `live()` in v3/v4) to trigger re-renders on change.
   - Note: The state of this field will be an array of Role IDs.

2. **Customer Select Field**:
   - Uses `visible()` and `required()` closures.
   - These closures use the `$get` helper to inspect the `roles` field.
   - Logic must translate Role IDs to the "Hospital Admin" role name to check for its presence.

## Technical Details
- To avoid hardcoding IDs, the visibility check should ideally verify if any of the selected Role IDs correspond to the 'Hospital Admin' role. 
- A simple way is to use `Role::whereIn('id', $get('roles'))->where('name', 'Hospital Admin')->exists()`.
- However, for better performance in the UI, we might fetch the ID of 'Hospital Admin' once or rely on the state having the names if we change how roles are handled (but staying with Spatie defaults is better).

## Trade-offs
- **Reactive Database Hits**: Checking `exists()` in a visibility closure might trigger multiple queries. 
- **Alternative**: Load all roles with IDs in memory once or use a fixed ID if we can guarantee it (less safe).
- **Decision**: Use a closure that checks the roles relationship or a cached ID. Given Filament's lifecycle, a clean check is preferred.
