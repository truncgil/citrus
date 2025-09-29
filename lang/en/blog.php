<?php

return [
    'title' => 'Blog Posts',
    'navigation_label' => 'Blog',
    'model_label' => 'Blog Post',
    'plural_model_label' => 'Blog Posts',
    
    // Actions
    'create' => 'Create New Blog Post',
    'edit' => 'Edit Blog Post',
    'delete' => 'Delete Blog Post',
    'restore' => 'Restore Blog Post',
    'force_delete' => 'Force Delete',
    
    // Form fields
    'title_field' => 'Title',
    'slug_field' => 'URL Slug',
    'content_field' => 'Content',
    'excerpt_field' => 'Excerpt',
    'meta_title_field' => 'Meta Title',
    'meta_description_field' => 'Meta Description',
    'status_field' => 'Status',
    'featured_image_field' => 'Featured Image',
    'published_at_field' => 'Published At',
    'author_field' => 'Author',
    'category_field' => 'Category',
    'tags_field' => 'Tags',
    'view_count_field' => 'View Count',
    'is_featured_field' => 'Featured',
    'allow_comments_field' => 'Allow Comments',
    
    // Sections
    'content_section' => 'Content',
    'settings_section' => 'Blog Settings',
    'seo_section' => 'SEO Settings',
    
    // Helper texts
    'slug_helper' => 'The part that will appear in the URL. Example: blog-post',
    'excerpt_helper' => 'Blog post excerpt (maximum 500 characters)',
    'featured_image_helper' => 'Select a featured image for the blog post',
    'category_helper' => 'Assign the blog post to a category',
    'tags_helper' => 'Add tags for the blog post',
    'published_at_helper' => 'If left blank, current date will be used',
    'is_featured_helper' => 'Mark this blog post as featured',
    'allow_comments_helper' => 'Allow comments on this blog post',
    'meta_title_helper' => 'Title for search engines (maximum 60 characters)',
    'meta_description_helper' => 'Description for search engines (maximum 160 characters)',
    
    // Status options
    'status_draft' => 'Draft',
    'status_published' => 'Published',
    'status_archived' => 'Archived',
    
    // Messages
    'created_successfully' => 'Blog post created successfully.',
    'updated_successfully' => 'Blog post updated successfully.',
    'deleted_successfully' => 'Blog post deleted successfully.',
    'restored_successfully' => 'Blog post restored successfully.',
    
    // Table columns
    'table_title' => 'Title',
    'table_slug' => 'URL Slug',
    'table_status' => 'Status',
    'table_author' => 'Author',
    'table_category' => 'Category',
    'table_published_at' => 'Published At',
    'table_view_count' => 'Views',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Validation messages
    'title_required' => 'Title field is required.',
    'slug_required' => 'URL slug field is required.',
    'slug_unique' => 'This URL slug is already in use.',
    'content_required' => 'Content field is required.',
    'author_required' => 'Author field is required.',
];
