<?php

return [
    'title' => 'Pages',
    'navigation_label' => 'Pages',
    'model_label' => 'Page',
    'plural_model_label' => 'Pages',
    
    // Actions
    'create' => 'Create New Page',
    'edit' => 'Edit Page',
    'delete' => 'Delete Page',
    'restore' => 'Restore Page',
    'force_delete' => 'Force Delete',
    
    // Form fields
    'title_field' => 'Title',
    'slug_field' => 'URL Slug',
    'content_field' => 'Content',
    'meta_title_field' => 'Meta Title',
    'meta_description_field' => 'Meta Description',
    'status_field' => 'Status',
    'published_at_field' => 'Published At',
    
    // Status options
    'status_draft' => 'Draft',
    'status_published' => 'Published',
    'status_archived' => 'Archived',
    
    // Messages
    'created_successfully' => 'Page created successfully.',
    'updated_successfully' => 'Page updated successfully.',
    'deleted_successfully' => 'Page deleted successfully.',
    'restored_successfully' => 'Page restored successfully.',
    
    // Table columns
    'table_title' => 'Title',
    'table_slug' => 'URL Slug',
    'table_status' => 'Status',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Validation messages
    'title_required' => 'The title field is required.',
    'slug_required' => 'The URL slug field is required.',
    'slug_unique' => 'This URL slug is already taken.',
    'content_required' => 'The content field is required.',
];
