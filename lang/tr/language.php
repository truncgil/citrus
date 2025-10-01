<?php

return [
    // Navigation & Labels
    'title' => 'Diller',
    'navigation_label' => 'Diller',
    'model_label' => 'Dil',
    'plural_model_label' => 'Diller',

    // Actions
    'create' => 'Dil Oluştur',
    'edit' => 'Dil Düzenle',
    'delete' => 'Dil Sil',
    'restore' => 'Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    'activate' => 'Aktif Et',
    'deactivate' => 'Pasif Et',
    'set_default' => 'Varsayılan Yap',

    // Form Sections
    'basic_information' => 'Temel Bilgiler',
    'settings' => 'Ayarlar',

    // Form Fields
    'code' => 'Dil Kodu',
    'code_helper' => 'ISO 639-1 dil kodu (örn: tr, en, de)',
    'name' => 'Dil Adı',
    'name_helper' => 'İngilizce dil adı (örn: Turkish)',
    'native_name' => 'Yerel Dil Adı',
    'native_name_helper' => 'Dil adının kendi dilindeki yazılışı (örn: Türkçe)',
    'flag' => 'Bayrak',
    'flag_helper' => 'Bayrak emojisi veya icon kodu',
    'direction' => 'Metin Yönü',
    'direction_ltr' => 'Soldan Sağa (LTR)',
    'direction_rtl' => 'Sağdan Sola (RTL)',
    'is_active' => 'Aktif',
    'is_active_helper' => 'Dil sistemde kullanılabilir mi?',
    'is_default' => 'Varsayılan Dil',
    'is_default_helper' => 'Bu dil varsayılan dil olsun mu?',
    'sort_order' => 'Sıralama',
    'sort_order_helper' => 'Dillerin görüntülenme sırası',

    // Table Columns
    'table_flag' => 'Bayrak',
    'table_code' => 'Kod',
    'table_name' => 'Dil Adı',
    'table_is_active' => 'Aktif',
    'table_is_default' => 'Varsayılan',
    'table_direction' => 'Yön',
    'table_sort_order' => 'Sıra',
    'table_created_at' => 'Oluşturulma',
    'table_updated_at' => 'Güncellenme',
    'table_deleted_at' => 'Silinme',

    // Messages
    'created_successfully' => 'Dil başarıyla oluşturuldu',
    'created_successfully_body' => 'Yeni dil sisteme eklendi.',
    'updated_successfully' => 'Dil başarıyla güncellendi',
    'updated_successfully_body' => 'Dil bilgileri güncellendi.',
    'deleted_successfully' => 'Dil başarıyla silindi',
    'deleted_successfully_body' => 'Dil sistemden kaldırıldı.',
    'restored_successfully' => 'Dil başarıyla geri yüklendi',
    'activated_successfully' => 'Dil aktif edildi',
    'deactivated_successfully' => 'Dil pasif edildi',
    'set_default_successfully' => 'Varsayılan dil güncellendi',
    'cannot_delete_default' => 'Varsayılan dil silinemez',
    'cannot_deactivate_default' => 'Varsayılan dil pasif edilemez',

    // Validation
    'code_required' => 'Dil kodu zorunludur',
    'code_unique' => 'Bu dil kodu zaten kullanılıyor',
    'name_required' => 'Dil adı zorunludur',
    'native_name_required' => 'Yerel dil adı zorunludur',
];

