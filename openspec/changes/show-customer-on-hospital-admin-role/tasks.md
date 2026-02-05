# Tasks: Show Customer select field when Hospital Admin role is selected

- [x] Update `UserForm::configure` to use `live()` on the roles field. <!-- id: 0 -->
- [x] Implement conditional visibility logic for `customer_id` using a robust role name check. <!-- id: 1 -->
- [x] Implement conditional requirement logic for `customer_id`. <!-- id: 2 -->
- [x] Add a test case to verify that `customer_id` is visible when "Hospital Admin" is selected. <!-- id: 3 -->
- [x] Add a test case to verify that `customer_id` is hidden for other roles. <!-- id: 4 -->
- [x] Verify that the `customer_id` is correctly saved to the user record. <!-- id: 5 -->
