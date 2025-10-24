<?php

return [
    'title' => 'Dashboard',
    'navigation_label' => 'Dashboard',
    
    // Widgets
    'widgets' => [
        'system_stats' => [
            'title' => 'System Statistics',
            'description' => 'Platform overview',
        ],
        'recent_activities' => [
            'title' => 'Recent Activities',
            'description' => 'Latest created content',
        ],
        'translation_progress' => [
            'title' => 'Translation Status',
            'description' => 'Translation progress by language',
        ],
        'user_activity' => [
            'title' => 'User Activity',
            'description' => 'Active users and roles',
        ],
        'content_overview' => [
            'title' => 'Content Overview',
            'description' => 'Pages and translation status',
        ],
    ],
    
    // Stats labels
    'stats' => [
        'total_users' => 'Total Users',
        'total_pages' => 'Total Pages',
        'total_translations' => 'Total Translations',
        'active_languages' => 'Active Languages',
        'published_pages' => 'Published Pages',
        'draft_translations' => 'Draft Translations',
        'pending_translations' => 'Pending Translations',
        'published_translations' => 'Published Translations',
    ],
    
    // Activity labels
    'activities' => [
        'recent_pages' => 'Recent Pages',
        'recent_translations' => 'Recent Translations',
        'recent_users' => 'Recent Users',
        'no_activity' => 'No activity yet',
        'view_all' => 'View All',
        'creator' => 'Creator',
    ],
    
    // Translation progress
    'translation_progress' => [
        'language' => 'Language',
        'native_name' => 'Native Name',
        'total_fields' => 'Total Fields',
        'translated_fields' => 'Translated Fields',
        'progress_percentage' => 'Progress',
        'status' => 'Status',
        'last_updated' => 'Last Updated',
        'active' => 'Active',
        'default' => 'Default',
    ],
    
    // User activity
    'user_activity' => [
        'active_users' => 'Active Users',
        'user_roles' => 'User Roles',
        'last_login' => 'Last Login',
        'created_at' => 'Created At',
        'role' => 'Role',
        'permissions' => 'Permissions',
        'username' => 'Username',
        'email' => 'Email',
        'email_verified' => 'Email Verified',
        'unverified' => 'Unverified',
    ],
    
    // Content overview
    'content_overview' => [
        'pages_by_status' => 'Pages by Status',
        'translations_by_status' => 'Translations by Status',
        'published' => 'Published',
        'draft' => 'Draft',
        'review' => 'Review',
        'approved' => 'Approved',
    ],
    
    // Messages
    'messages' => [
        'welcome' => 'Welcome to Citrus Platform!',
        'system_healthy' => 'System is running healthy',
        'no_data' => 'No data available yet',
        'loading' => 'Loading...',
    ],
    
    // Actions
    'actions' => [
        'create_page' => 'New Page',
        'create_translation' => 'New Translation',
        'manage_users' => 'User Management',
        'manage_languages' => 'Language Management',
        'view_reports' => 'View Reports',
    ],
];

