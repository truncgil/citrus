<?php

return [
    // Module labels
    'title' => 'Blog Categories',
    'navigation_label' => 'Blog Categories',
    'model_label' => 'Blog Category',
    'plural_model_label' => 'Blog Categories',
    
    // Actions
    'create' => 'Create New Blog Category',
    'edit' => 'Edit Blog Category',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete Blog Category',
    'restore' => 'Restore Blog Category',
    'force_delete' => 'Force Delete',
    
    // Sections
    'general_section' => 'General Information',
    
    // Form fields
    'name_field' => 'Category Name',
    'slug_field' => 'URL Slug',
    'description_field' => 'Description',
    'color_field' => 'Color',
    'sort_order_field' => 'Sort Order',
    'is_active_field' => 'Active',
    
    // Helper texts
    'slug_helper' => 'The part that will appear in the URL. Example: technology',
    'description_helper' => 'Category description (optional)',
    'color_helper' => 'Select category color (hex format)',
    'sort_order_helper' => 'Category listing order (smaller numbers appear first)',
    'is_active_helper' => 'Activate/deactivate category',
    
    // Messages
    'created_successfully' => 'Blog category created successfully.',
    'updated_successfully' => 'Blog category updated successfully.',
    'deleted_successfully' => 'Blog category deleted successfully.',
    'restored_successfully' => 'Blog category restored successfully.',
    
    // Table columns
    'blogs_count' => 'Blog Count',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Validation messages
    'name_required' => 'Category name field is required.',
    'slug_required' => 'URL slug field is required.',
    'slug_unique' => 'This URL slug is already in use.',
];

