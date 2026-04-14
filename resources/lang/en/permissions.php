<?php

return array (
  'label' => 'Permission',
  'plural_label' => 'Permissions',
  'navigation_label' => 'Permissions',
  'columns' => 
  array (
    'name' => 'Name',
    'guard_name' => 'Guard',
  ),
  'form' => 
  array (
    'name' => 
    array (
      'label' => 'Permission Name',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
    ),
  ),
  'actions' => 
  array (
    'edit' => 'Edit',
    'edit_success' => ':label edited successfully',
    'delete' => 'Delete',
    'delete_success' => ':label deleted successfully',
    'delete_multiple_success' => ':plural_label deleted successfully',
  ),
  'generate' => 
  array (
    'title' => 'Generate Permissions',
    'desc' => 'Generate permissions automatically',
    'button_label' => 'Generate Permissions',
    'success' => 'Permissions generated successfully',
    'count_success' => ':count permissions generated',
    'empty' => 'No permissions to generate',
  ),
);
