<?php

return array (
  'label' => 'Role',
  'plural_label' => 'Roles',
  'navigation_label' => 'Roles',
  'columns' => 
  array (
    'name' => 'Name',
    'guard_name' => 'Guard',
  ),
  'form' => 
  array (
    'name' => 
    array (
      'label' => 'Role Name',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
    ),
    'permissions' => 
    array (
      'label' => 'Permissions',
    ),
  ),
  'formpermissions' => 
  array (
    'label' => 'Role Permissions',
    'helper_text' => 'Select permissions for this role',
  ),
  'actions' => 
  array (
    'view' => 'View',
    'edit' => 'Edit',
    'edit_success' => ':label edited successfully',
    'delete' => 'Delete',
    'delete_success' => ':label deleted successfully',
    'delete_multiple_success' => ':label deleted successfully',
    'create_success' => ':label created successfully',
    'assign_permissions' => 'Assign Permissions',
    'assign_permissions_success' => 'Permissions assigned successfully',
    'add_new_permission' => 'Add New Permission',
  ),
  'sections' => 
  array (
    'role_details' => 'Role Details',
  ),
);
