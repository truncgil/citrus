<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // İlk kullanıcıyı bul veya oluştur
        $author = \App\Models\User::first();
        if (!$author) {
            $author = \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@truncgil.com',
                'password' => bcrypt('password'),
            ]);
        }

        // 1. Anasayfa
        $home = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'author_id' => $author->id,
                'title' => 'Anasayfa',
                'excerpt' => 'Modern ve yenilikçi teknoloji çözümleri',
                'content' => null,
                'template' => 'home',
                'status' => 'published',
                'is_homepage' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
                'published_at' => now(),
                'meta_title' => 'Truncgil Teknoloji - Kurumsal',
                'meta_description' => 'Truncgil Teknoloji kurumsal web sitesi.',
                'sections' => [], // Sections will be handled by the template view for now or can be added here
            ]
        );

        // 2. Kurumsal (Parent)
        $corporate = Page::updateOrCreate(
            ['slug' => 'kurumsal'],
            [
                'author_id' => $author->id,
                'title' => 'Kurumsal',
                'excerpt' => 'Kurumsal bilgilerimiz',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );

        // 2.1 Hakkımızda (Child of Kurumsal)
        Page::updateOrCreate(
            ['slug' => 'hakkimizda'],
            [
                'author_id' => $author->id,
                'parent_id' => $corporate->id,
                'title' => 'Hakkımızda',
                'excerpt' => 'Biz kimiz?',
                'content' => '<p>Hakkımızda içeriği...</p>',
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );

        // 2.2 Vizyon & Misyon (Child of Kurumsal)
        Page::updateOrCreate(
            ['slug' => 'vizyon-misyon'],
            [
                'author_id' => $author->id,
                'parent_id' => $corporate->id,
                'title' => 'Vizyon & Misyon',
                'excerpt' => 'Gelecek hedeflerimiz',
                'content' => '<p>Vizyon ve Misyon içeriği...</p>',
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );

        // 3. Ürünlerimiz (Mega Menu Target)
        Page::updateOrCreate(
            ['slug' => 'urunlerimiz'],
            [
                'author_id' => $author->id,
                'title' => 'Ürünlerimiz',
                'excerpt' => 'Ürün ve hizmetlerimiz',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 3,
                'published_at' => now(),
            ]
        );

        // 4. Blog
        Page::updateOrCreate(
            ['slug' => 'blog'],
            [
                'author_id' => $author->id,
                'title' => 'Blog',
                'excerpt' => 'Güncel haberler ve makaleler',
                'content' => null,
                'template' => 'blog',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 4,
                'published_at' => now(),
            ]
        );

        // 5. İletişim
        Page::updateOrCreate(
            ['slug' => 'iletisim'],
            [
                'author_id' => $author->id,
                'title' => 'İletişim',
                'excerpt' => 'Bize ulaşın',
                'content' => null,
                'template' => 'contact',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 5,
                'published_at' => now(),
            ]
        );

        $this->command->info('✅ Menu yapısı ve sayfalar başarıyla oluşturuldu!');
    }
}
