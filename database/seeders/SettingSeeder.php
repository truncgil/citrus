<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Genel Ayarlar
            [
                'key' => 'site_name',
                'value' => 'Citrus Platform',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Adı',
                'description' => 'Web sitesinin adı',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Modern ve güvenilir web platformu',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Açıklaması',
                'description' => 'Web sitesinin açıklaması',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'site_keywords',
                'value' => 'citrus, platform, web, modern',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Anahtar Kelimeleri',
                'description' => 'SEO için anahtar kelimeler',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Bakım Modu',
                'description' => 'Site bakım modunda mı?',
                'is_public' => false,
                'is_active' => true,
            ],
            
            // E-posta Ayarları
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@citrus.truncgil.com',
                'type' => 'string',
                'group' => 'email',
                'label' => 'E-posta Gönderen Adres',
                'description' => 'Sistem e-postalarının gönderileceği adres',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'Citrus Platform',
                'type' => 'string',
                'group' => 'email',
                'label' => 'E-posta Gönderen İsim',
                'description' => 'Sistem e-postalarının gönderen adı',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'mail_notifications_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'email',
                'label' => 'E-posta Bildirimleri Aktif',
                'description' => 'E-posta bildirimleri gönderilsin mi?',
                'is_public' => false,
                'is_active' => true,
            ],
            
            // SEO Ayarları
            [
                'key' => 'seo_meta_title',
                'value' => 'Citrus Platform - Modern Web Platformu',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'SEO Meta Başlık',
                'description' => 'Varsayılan SEO meta başlığı',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'seo_meta_description',
                'value' => 'Modern ve güvenilir web platformu',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Meta Açıklama',
                'description' => 'Varsayılan SEO meta açıklaması',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'seo_google_analytics',
                'value' => '',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Google Analytics ID',
                'description' => 'Google Analytics takip kodu',
                'is_public' => false,
                'is_active' => true,
            ],
            
            // Sosyal Medya Ayarları
            [
                'key' => 'social_facebook',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook sayfa URL\'si',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'social_twitter',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profil URL\'si',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'social_instagram',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profil URL\'si',
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'key' => 'social_linkedin',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn profil URL\'si',
                'is_public' => true,
                'is_active' => true,
            ],
            
            // Güvenlik Ayarları
            [
                'key' => 'security_max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Maksimum Giriş Denemesi',
                'description' => 'Kullanıcı hesabının kilitlenmesi için maksimum giriş denemesi',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'security_session_timeout',
                'value' => '120',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Oturum Zaman Aşımı (dakika)',
                'description' => 'Kullanıcı oturumunun zaman aşımına uğrayacağı süre',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'security_2fa_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'İki Faktörlü Doğrulama',
                'description' => 'İki faktörlü doğrulama aktif mi?',
                'is_public' => false,
                'is_active' => true,
            ],
            
            // Bildirim Ayarları
            [
                'key' => 'notification_email_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'E-posta Bildirimleri',
                'description' => 'E-posta bildirimleri gönderilsin mi?',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'notification_sms_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'SMS Bildirimleri',
                'description' => 'SMS bildirimleri gönderilsin mi?',
                'is_public' => false,
                'is_active' => true,
            ],
            [
                'key' => 'notification_push_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'Push Bildirimleri',
                'description' => 'Push bildirimleri gönderilsin mi?',
                'is_public' => false,
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
