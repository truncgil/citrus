<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Sol kolon - Ana içerik (2 sütun genişliğinde)
                Section::make('İçerik')
                    ->schema([
                        TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', \Str::slug($state));
                            }),
                        
                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('URL\'de görünecek kısım. Örnek: hakkimizda'),
                        
                        RichEditor::make('content')
                            ->label('İçerik')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('pages')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull(),
                        
                        Textarea::make('excerpt')
                            ->label('Özet')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Sayfa özeti (maksimum 500 karakter)')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->collapsible(false),
                
                // Sağ kolon - Metadata ve öne çıkan görsel (1 sütun genişliğinde)
                Section::make('Sayfa Ayarları')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Öne Çıkan Görsel')
                            ->image()
                            ->disk('public')
                            ->directory('pages/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Sayfa için öne çıkan görsel seçin')
                            ->columnSpanFull(),
                        
                        Select::make('author_id')
                            ->label('Yazar')
                            ->relationship('author', 'name')
                            ->default(auth()->id())
                            ->required()
                            ->columnSpanFull(),
                        
                        DateTimePicker::make('published_at')
                            ->label('Yayın Tarihi')
                            ->displayFormat('d.m.Y H:i')
                            ->helperText('Boş bırakılırsa şu anki tarih kullanılır')
                            ->columnSpanFull(),
                        
                        Select::make('status')
                            ->label('Durum')
                            ->options([
                                'draft' => 'Taslak',
                                'published' => 'Yayında',
                                'archived' => 'Arşivlendi',
                            ])
                            ->default('draft')
                            ->required()
                            ->columnSpanFull(),
                        
                        Select::make('parent_id')
                            ->label('Üst Sayfa')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Bu sayfayı başka bir sayfanın alt sayfası yapmak için seçin')
                            ->columnSpanFull(),
                        
                        Select::make('template')
                            ->label('Şablon')
                            ->options([
                                'default' => 'Varsayılan',
                                'landing' => 'Landing Page',
                                'blog' => 'Blog',
                                'contact' => 'İletişim',
                            ])
                            ->default('default')
                            ->columnSpanFull(),
                        
                        TextInput::make('sort_order')
                            ->label('Sıra')
                            ->numeric()
                            ->default(0)
                            ->helperText('Menüde görünme sırası')
                            ->columnSpanFull(),
                        
                        Checkbox::make('is_homepage')
                            ->label('Ana Sayfa')
                            ->helperText('Bu sayfayı ana sayfa olarak ayarla')
                            ->columnSpanFull(),
                        
                        Checkbox::make('show_in_menu')
                            ->label('Menüde Göster')
                            ->default(true)
                            ->helperText('Bu sayfa menüde görünsün mü?')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1)
                    ->collapsible(false),
                
                // Alt kısım - SEO ayarları (tam genişlik)
                Section::make('SEO Ayarları')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Başlık')
                            ->maxLength(60)
                            ->helperText('Arama motorları için başlık (maksimum 60 karakter)'),
                        
                        Textarea::make('meta_description')
                            ->label('Meta Açıklama')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Arama motorları için açıklama (maksimum 160 karakter)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
            ]);
    }
}
