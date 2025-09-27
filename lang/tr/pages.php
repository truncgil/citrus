<?php

return [
    'title' => 'Sayfalar',
    'navigation_label' => 'Sayfalar',
    'model_label' => 'Sayfa',
    'plural_model_label' => 'Sayfalar',
    
    // Actions
    'create' => 'Yeni Sayfa Oluştur',
    'edit' => 'Sayfayı Düzenle',
    'delete' => 'Sayfayı Sil',
    'restore' => 'Sayfayı Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Form fields
    'title_field' => 'Başlık',
    'slug_field' => 'URL Yolu',
    'content_field' => 'İçerik',
    'meta_title_field' => 'Meta Başlık',
    'meta_description_field' => 'Meta Açıklama',
    'status_field' => 'Durum',
    'published_at_field' => 'Yayın Tarihi',
    
    // Status options
    'status_draft' => 'Taslak',
    'status_published' => 'Yayınlandı',
    'status_archived' => 'Arşivlendi',
    
    // Messages
    'created_successfully' => 'Sayfa başarıyla oluşturuldu.',
    'updated_successfully' => 'Sayfa başarıyla güncellendi.',
    'deleted_successfully' => 'Sayfa başarıyla silindi.',
    'restored_successfully' => 'Sayfa başarıyla geri yüklendi.',
    
    // Table columns
    'table_title' => 'Başlık',
    'table_slug' => 'URL Yolu',
    'table_status' => 'Durum',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Validation messages
    'title_required' => 'Başlık alanı zorunludur.',
    'slug_required' => 'URL yolu alanı zorunludur.',
    'slug_unique' => 'Bu URL yolu zaten kullanılıyor.',
    'content_required' => 'İçerik alanı zorunludur.',
];
