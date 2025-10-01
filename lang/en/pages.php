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
    
    // Form sections
    'form_section_content' => 'Content',
    'form_section_page_settings' => 'Page Settings',
    'form_section_seo_settings' => 'SEO Settings',
    'translations_section' => 'Translations',
    
    // Form fields
    'title_field' => 'Title',
    'slug_field' => 'URL Slug',
    'content_field' => 'Content',
    'excerpt_field' => 'Excerpt',
    'featured_image_field' => 'Featured Image',
    'author_field' => 'Author',
    'published_at_field' => 'Published At',
    'status_field' => 'Status',
    'parent_field' => 'Parent Page',
    'template_field' => 'Template',
    'sort_order_field' => 'Sort Order',
    'is_homepage_field' => 'Homepage',
    'show_in_menu_field' => 'Show in Menu',
    'meta_title_field' => 'Meta Title',
    'meta_description_field' => 'Meta Description',
    
    // Helper texts
    'slug_helper_text' => 'The part that will appear in the URL. Example: about-us',
    'excerpt_helper_text' => 'Page excerpt (maximum 500 characters)',
    'featured_image_helper_text' => 'Select a featured image for the page',
    'published_at_helper_text' => 'If left empty, current date will be used',
    'parent_helper_text' => 'Select to make this page a sub-page of another page',
    'sort_order_helper_text' => 'Display order in menu',
    'is_homepage_helper_text' => 'Set this page as the homepage',
    'show_in_menu_helper_text' => 'Should this page be shown in menu?',
    'meta_title_helper_text' => 'Title for search engines (maximum 60 characters)',
    'meta_description_helper_text' => 'Description for search engines (maximum 160 characters)',
    
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
    'table_column_featured_image' => 'Featured Image',
    'table_column_title' => 'Title',
    'table_column_slug' => 'URL Slug',
    'table_column_status' => 'Status',
    'table_column_author' => 'Author',
    'table_column_published_at' => 'Published At',
    'table_column_parent' => 'Parent Page',
    'table_column_template' => 'Template',
    'table_column_is_homepage' => 'Homepage',
    'table_column_show_in_menu' => 'Show in Menu',
    'table_column_sort_order' => 'Sort Order',
    'table_column_created_at' => 'Created At',
    'table_column_updated_at' => 'Updated At',
    
    // Template options
    'template_default' => 'Default',
    'template_landing' => 'Landing Page',
    'template_blog' => 'Blog',
    'template_contact' => 'Contact',
    
    // Copy message
    'copy_url_message' => 'URL copied',
    
    // Validation messages
    'title_required' => 'The title field is required.',
    'slug_required' => 'The URL slug field is required.',
    'slug_unique' => 'This URL slug is already taken.',
    'content_required' => 'The content field is required.',
];
