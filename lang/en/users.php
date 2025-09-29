<?php

return [
    'title' => 'User Management',
    'navigation_label' => 'Users',
    'model_label' => 'User',
    'plural_model_label' => 'Users',
    
    // Actions
    'create' => 'Create User',
    'edit' => 'Edit User',
    'delete' => 'Delete User',
    'restore' => 'Restore User',
    'force_delete' => 'Force Delete User',
    
    // Form fields
    'name' => 'Full Name',
    'email' => 'Email',
    'password' => 'Password',
    'password_confirmation' => 'Confirm Password',
    'roles' => 'Roles',
    'permissions' => 'Permissions',
    'is_active' => 'Active',
    'email_verified_at' => 'Email Verified At',
    
    // Messages
    'created_successfully' => 'User created successfully.',
    'updated_successfully' => 'User updated successfully.',
    'deleted_successfully' => 'User deleted successfully.',
    'restored_successfully' => 'User restored successfully.',
    
    // Table columns
    'table_name' => 'Full Name',
    'table_email' => 'Email',
    'table_roles' => 'Roles',
    'table_status' => 'Status',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Status
    'status_active' => 'Active',
    'status_inactive' => 'Inactive',
    
    // Validation messages
    'name_required' => 'Full name field is required.',
    'email_required' => 'Email field is required.',
    'email_unique' => 'This email address is already in use.',
    'password_required' => 'Password field is required.',
    'password_min' => 'Password must be at least 8 characters.',
    'password_confirmation_required' => 'Password confirmation field is required.',
    'password_confirmation_same' => 'Password confirmation does not match password.',
    
    // Roles
    'roles_title' => 'Role Management',
    'roles_navigation_label' => 'Roles',
    'roles_model_label' => 'Role',
    'roles_plural_model_label' => 'Roles',
    
    'role_name' => 'Role Name',
    'role_guard_name' => 'Guard Name',
    'role_permissions' => 'Permissions',
    
    'role_created_successfully' => 'Role created successfully.',
    'role_updated_successfully' => 'Role updated successfully.',
    'role_deleted_successfully' => 'Role deleted successfully.',
    
    // Permissions
    'permissions_title' => 'Permission Management',
    'permissions_navigation_label' => 'Permissions',
    'permissions_model_label' => 'Permission',
    'permissions_plural_model_label' => 'Permissions',
    
    'permission_name' => 'Permission Name',
    'permission_guard_name' => 'Guard Name',
    
    'permission_created_successfully' => 'Permission created successfully.',
    'permission_updated_successfully' => 'Permission updated successfully.',
    'permission_deleted_successfully' => 'Permission deleted successfully.',
];
