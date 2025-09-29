<?php

return [
    'title' => 'Kullanıcı Yönetimi',
    'navigation_label' => 'Kullanıcılar',
    'model_label' => 'Kullanıcı',
    'plural_model_label' => 'Kullanıcılar',
    
    // Actions
    'create' => 'Kullanıcı Oluştur',
    'edit' => 'Kullanıcı Düzenle',
    'delete' => 'Kullanıcı Sil',
    'restore' => 'Kullanıcıyı Geri Yükle',
    'force_delete' => 'Kullanıcıyı Kalıcı Olarak Sil',
    
    // Form fields
    'name' => 'Ad Soyad',
    'email' => 'E-posta',
    'password' => 'Şifre',
    'password_confirmation' => 'Şifre Tekrarı',
    'roles' => 'Roller',
    'permissions' => 'İzinler',
    'is_active' => 'Aktif',
    'email_verified_at' => 'E-posta Doğrulama Tarihi',
    
    // Messages
    'created_successfully' => 'Kullanıcı başarıyla oluşturuldu.',
    'updated_successfully' => 'Kullanıcı başarıyla güncellendi.',
    'deleted_successfully' => 'Kullanıcı başarıyla silindi.',
    'restored_successfully' => 'Kullanıcı başarıyla geri yüklendi.',
    
    // Table columns
    'table_name' => 'Ad Soyad',
    'table_email' => 'E-posta',
    'table_roles' => 'Roller',
    'table_status' => 'Durum',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Status
    'status_active' => 'Aktif',
    'status_inactive' => 'Pasif',
    
    // Validation messages
    'name_required' => 'Ad soyad alanı zorunludur.',
    'email_required' => 'E-posta alanı zorunludur.',
    'email_unique' => 'Bu e-posta adresi zaten kullanılıyor.',
    'password_required' => 'Şifre alanı zorunludur.',
    'password_min' => 'Şifre en az 8 karakter olmalıdır.',
    'password_confirmation_required' => 'Şifre tekrarı alanı zorunludur.',
    'password_confirmation_same' => 'Şifre tekrarı şifre ile eşleşmiyor.',
    
    // Roles
    'roles_title' => 'Rol Yönetimi',
    'roles_navigation_label' => 'Roller',
    'roles_model_label' => 'Rol',
    'roles_plural_model_label' => 'Roller',
    
    'role_name' => 'Rol Adı',
    'role_guard_name' => 'Guard Adı',
    'role_permissions' => 'İzinler',
    
    'role_created_successfully' => 'Rol başarıyla oluşturuldu.',
    'role_updated_successfully' => 'Rol başarıyla güncellendi.',
    'role_deleted_successfully' => 'Rol başarıyla silindi.',
    
    // Permissions
    'permissions_title' => 'İzin Yönetimi',
    'permissions_navigation_label' => 'İzinler',
    'permissions_model_label' => 'İzin',
    'permissions_plural_model_label' => 'İzinler',
    
    'permission_name' => 'İzin Adı',
    'permission_guard_name' => 'Guard Adı',
    
    'permission_created_successfully' => 'İzin başarıyla oluşturuldu.',
    'permission_updated_successfully' => 'İzin başarıyla güncellendi.',
    'permission_deleted_successfully' => 'İzin başarıyla silindi.',
];
