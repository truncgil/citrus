<?php

return [
    // Module labels
    'title' => 'Blog Kategorileri',
    'navigation_label' => 'Blog Kategorileri',
    'model_label' => 'Blog Kategorisi',
    'plural_model_label' => 'Blog Kategorileri',
    
    // Actions
    'create' => 'Yeni Blog Kategorisi Oluştur',
    'edit' => 'Blog Kategorisini Düzenle',
    'save' => 'Kaydet',
    'cancel' => 'İptal',
    'delete' => 'Blog Kategorisini Sil',
    'restore' => 'Blog Kategorisini Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Sections
    'general_section' => 'Genel Bilgiler',
    
    // Form fields
    'name_field' => 'Kategori Adı',
    'slug_field' => 'URL Yolu',
    'description_field' => 'Açıklama',
    'color_field' => 'Renk',
    'sort_order_field' => 'Sıralama',
    'is_active_field' => 'Aktif',
    
    // Helper texts
    'slug_helper' => 'URL\'de görünecek kısım. Örnek: teknoloji',
    'description_helper' => 'Kategori açıklaması (isteğe bağlı)',
    'color_helper' => 'Kategori rengini seçin (hex formatında)',
    'sort_order_helper' => 'Kategorilerin listelenme sırası (küçük sayılar önce gelir)',
    'is_active_helper' => 'Kategoriyi aktif/pasif yap',
    
    // Messages
    'created_successfully' => 'Blog kategorisi başarıyla oluşturuldu.',
    'updated_successfully' => 'Blog kategorisi başarıyla güncellendi.',
    'deleted_successfully' => 'Blog kategorisi başarıyla silindi.',
    'restored_successfully' => 'Blog kategorisi başarıyla geri yüklendi.',
    
    // Table columns
    'blogs_count' => 'Blog Sayısı',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Validation messages
    'name_required' => 'Kategori adı alanı zorunludur.',
    'slug_required' => 'URL yolu alanı zorunludur.',
    'slug_unique' => 'Bu URL yolu zaten kullanılıyor.',
];

