<?php

return [
	// Navigation & list
	'nav-blog' => 'Blog',
	'meta-index-title' => 'Blog',
	'meta-index-description' => 'Güncel paylaşımlarımız',
	'empty' => 'Şu anda blog yazısı bulunmuyor.',

	// Module labels
    'title' => 'Blog Yazıları',
    'navigation_label' => 'Blog',
    'model_label' => 'Blog Yazısı',
    'plural_model_label' => 'Blog Yazıları',
    
    // Actions
    'create' => 'Yeni Blog Yazısı Oluştur',
    'edit' => 'Blog Yazısını Düzenle',
    'save' => 'Kaydet',
    'cancel' => 'İptal',
    'delete' => 'Blog Yazısını Sil',
    'restore' => 'Blog Yazısını Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Form fields
    'title_field' => 'Başlık',
    'slug_field' => 'URL Yolu',
    'content_field' => 'İçerik',
    'excerpt_field' => 'Özet',
    'meta_title_field' => 'Meta Başlık',
    'meta_description_field' => 'Meta Açıklama',
    'status_field' => 'Durum',
    'featured_image_field' => 'Öne Çıkan Görsel',
    'published_at_field' => 'Yayın Tarihi',
    'author_field' => 'Yazar',
    'category_field' => 'Kategori',
    'tags_field' => 'Etiketler',
    'view_count_field' => 'Görüntülenme Sayısı',
    'is_featured_field' => 'Öne Çıkan',
    'allow_comments_field' => 'Yorumlara İzin Ver',
    
    // Sections
    'content_section' => 'İçerik',
    'settings_section' => 'Blog Ayarları',
    'seo_section' => 'SEO Ayarları',
    'translations_section' => 'Çeviriler',
    
    // Helper texts
    'slug_helper' => 'URL\'de görünecek kısım. Örnek: blog-yazisi',
    'excerpt_helper' => 'Blog yazısı özeti (maksimum 500 karakter)',
    'featured_image_helper' => 'Blog yazısı için öne çıkan görsel seçin',
    'category_helper' => 'Blog yazısını bir kategoriye atayın',
    'tags_helper' => 'Blog yazısı için etiketler ekleyin',
    'published_at_helper' => 'Boş bırakılırsa şu anki tarih kullanılır',
    'is_featured_helper' => 'Bu blog yazısını öne çıkan olarak işaretle',
    'allow_comments_helper' => 'Bu blog yazısında yorumlara izin ver',
    'meta_title_helper' => 'Arama motorları için başlık (maksimum 60 karakter)',
    'meta_description_helper' => 'Arama motorları için açıklama (maksimum 160 karakter)',
    
    // Status options
    'status_draft' => 'Taslak',
    'status_published' => 'Yayınlandı',
    'status_archived' => 'Arşivlendi',
    
    // Messages
    'created_successfully' => 'Blog yazısı başarıyla oluşturuldu.',
    'updated_successfully' => 'Blog yazısı başarıyla güncellendi.',
    'deleted_successfully' => 'Blog yazısı başarıyla silindi.',
    'restored_successfully' => 'Blog yazısı başarıyla geri yüklendi.',
    
    // Table columns
    'table_title' => 'Başlık',
    'table_slug' => 'URL Yolu',
    'table_status' => 'Durum',
    'table_author' => 'Yazar',
    'table_category' => 'Kategori',
    'table_published_at' => 'Yayın Tarihi',
    'table_view_count' => 'Görüntülenme',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Validation messages
    'title_required' => 'Başlık alanı zorunludur.',
    'slug_required' => 'URL yolu alanı zorunludur.',
    'slug_unique' => 'Bu URL yolu zaten kullanılıyor.',
    'content_required' => 'İçerik alanı zorunludur.',
    'author_required' => 'Yazar alanı zorunludur.',
];
