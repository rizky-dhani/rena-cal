<?php

return array (
  'label' => 'Customer',
  'plural_label' => 'Customers',
  'navigation_label' => 'Customers',
  'columns' => 
  array (
    'name' => 'Name',
    'phone_number' => 'Phone Number',
    'address' => 'Address',
  ),
  'form' => 
  array (
    'name' => 
    array (
      'label' => 'Customer Name',
    ),
    'phone_number' => 
    array (
      'label' => 'Phone Number',
    ),
    'province' => 
    array (
      'label' => 'Province',
    ),
    'categories' => 
    array (
      'label' => 'Categories',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'options' => 
      array (
        'Pemerintah' => 'Government',
        'Swasta' => 'Private',
      ),
    ),
    'address' => 
    array (
      'label' => 'Address',
    ),
    'create_new_user' => 
    array (
      'label' => 'Create New User',
    ),
    'select_user' => 
    array (
      'label' => 'Select User',
    ),
    'new_user_name' => 
    array (
      'label' => 'New User Name',
    ),
    'new_user_email' => 
    array (
      'label' => 'New User Email',
    ),
    'new_user_phone' => 
    array (
      'label' => 'New User Phone',
    ),
    'delete_user' => 
    array (
      'label' => 'Delete User',
      'helper_text' => 'Delete associated user',
    ),
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
    'assign_admin' => 'Make Admin',
    'assign_admin_success' => ':label made admin successfully',
    'unassign_admin' => 'Remove Admin',
    'unassign_admin_success' => ':label removed as admin successfully',
  ),
  'sections' => 
  array (
    'details' => 'Customer Details',
  ),
);
