<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\ContentSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\FooterTemplateSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\HeaderTemplateSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\PageSettingsSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\SectionBuilderSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\SectionTemplatesSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\SeoSection;
use App\Filament\Admin\Resources\Pages\Schemas\Sections\TranslationsSection;

use Filament\Schemas\Schema;

class PageForm
{
    /**
     * Configure the page form schema with modular sections.
     * 
     * This form is organized into 8 sections for better maintainability:
     * 1. Content - Basic page content (title, slug, content, excerpt)
     * 2. Page Settings - Metadata and settings (image, author, status, etc.)
     * 3. SEO - SEO metadata (meta title, meta description)
     * 4. Section Builder - Dynamic page sections
     * 5. Header Template - Dynamic header template system
     * 6. Section Templates - Repeatable section templates
     * 7. Footer Template - Dynamic footer template system
     * 8. Translations - Multi-language support
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Left Column - Main Content (2 columns width)
                ContentSection::make(),
                
                // Right Column - Settings and Metadata (1 column width)
                PageSettingsSection::make(),
                
                // Full Width - SEO Settings
                SeoSection::make(),
                
                // Full Width - Section Builder (Custom Page Sections)
              //  SectionBuilderSection::make(),
                
                // Full Width - Dynamic Template System
                HeaderTemplateSection::make(),
                SectionTemplatesSection::make(),
                FooterTemplateSection::make(),
                
                // Full Width - Translations
                TranslationsSection::make(),
            ]);
    }
}
