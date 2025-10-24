<?php

return [
    'title' => 'Dashboard',
    'navigation_label' => 'Dashboard',
    
    // Widgets
    'widgets' => [
        'system_stats' => [
            'title' => 'Sistem İstatistikleri',
            'description' => 'Platform genel durumu',
        ],
        'recent_activities' => [
            'title' => 'Son Aktiviteler',
            'description' => 'Son oluşturulan içerikler',
        ],
        'translation_progress' => [
            'title' => 'Çeviri Durumu',
            'description' => 'Dil bazında çeviri ilerlemesi',
        ],
        'user_activity' => [
            'title' => 'Kullanıcı Aktivitesi',
            'description' => 'Aktif kullanıcılar ve roller',
        ],
        'content_overview' => [
            'title' => 'İçerik Özeti',
            'description' => 'Sayfa ve çeviri durumu',
        ],
    ],
    
    // Stats labels
    'stats' => [
        'total_users' => 'Toplam Kullanıcı',
        'total_pages' => 'Toplam Sayfa',
        'total_translations' => 'Toplam Çeviri',
        'active_languages' => 'Aktif Dil',
        'published_pages' => 'Yayınlanan Sayfa',
        'draft_translations' => 'Taslak Çeviri',
        'pending_translations' => 'Bekleyen Çeviri',
        'published_translations' => 'Yayınlanan Çeviri',
    ],
    
    // Activity labels
    'activities' => [
        'recent_pages' => 'Son Sayfalar',
        'recent_translations' => 'Son Çeviriler',
        'recent_users' => 'Son Kullanıcılar',
        'no_activity' => 'Henüz aktivite yok',
        'view_all' => 'Tümünü Görüntüle',
        'creator' => 'Oluşturan',
    ],
    
    // Translation progress
    'translation_progress' => [
        'language' => 'Dil',
        'native_name' => 'Yerel Ad',
        'total_fields' => 'Toplam Alan',
        'translated_fields' => 'Çevrilen Alan',
        'progress_percentage' => 'İlerleme',
        'status' => 'Durum',
        'last_updated' => 'Son Güncelleme',
        'active' => 'Aktif',
        'default' => 'Varsayılan',
    ],
    
    // User activity
    'user_activity' => [
        'active_users' => 'Aktif Kullanıcılar',
        'user_roles' => 'Kullanıcı Rolleri',
        'last_login' => 'Son Giriş',
        'created_at' => 'Oluşturulma',
        'role' => 'Rol',
        'permissions' => 'Yetkiler',
        'username' => 'Kullanıcı Adı',
        'email' => 'E-posta',
        'email_verified' => 'E-posta Doğrulandı',
        'unverified' => 'Doğrulanmamış',
    ],
    
    // Content overview
    'content_overview' => [
        'pages_by_status' => 'Sayfa Durumları',
        'translations_by_status' => 'Çeviri Durumları',
        'published' => 'Yayınlanan',
        'draft' => 'Taslak',
        'review' => 'İnceleme',
        'approved' => 'Onaylanan',
    ],
    
    // Messages
    'messages' => [
        'welcome' => 'Citrus Platform\'a hoş geldiniz!',
        'system_healthy' => 'Sistem sağlıklı çalışıyor',
        'no_data' => 'Henüz veri bulunmuyor',
        'loading' => 'Yükleniyor...',
    ],
    
    // Actions
    'actions' => [
        'create_page' => 'Yeni Sayfa',
        'create_translation' => 'Yeni Çeviri',
        'manage_users' => 'Kullanıcı Yönetimi',
        'manage_languages' => 'Dil Yönetimi',
        'view_reports' => 'Raporları Görüntüle',
    ],
];

