<?php

namespace App\Services;

use App\Models\Setting;

class TemplatePreviewService
{
    /**
     * Get all CSS assets for preview
     *
     * @return array
     */
    public static function getCssAssets(): array
    {
        $config = config('template-preview.css', []);
        
        if (config('template-preview.use_settings_override', false)) {
            $settingsKeys = config('template-preview.settings_keys', []);
            
            foreach ($settingsKeys as $assetKey => $settingKey) {
                if (str_starts_with($assetKey, 'css_')) {
                    $setting = Setting::get($settingKey);
                    if ($setting) {
                        $configKey = str_replace('css_', '', $assetKey);
                        $config[$configKey] = $setting;
                    }
                }
            }
        }

        return $config;
    }

    /**
     * Get all JavaScript assets for preview
     *
     * @return array
     */
    public static function getJsAssets(): array
    {
        $config = config('template-preview.js', []);
        
        if (config('template-preview.use_settings_override', false)) {
            $settingsKeys = config('template-preview.settings_keys', []);
            
            foreach ($settingsKeys as $assetKey => $settingKey) {
                if (str_starts_with($assetKey, 'js_')) {
                    $setting = Setting::get($settingKey);
                    if ($setting) {
                        $configKey = str_replace('js_', '', $assetKey);
                        $config[$configKey] = $setting;
                    }
                }
            }
        }

        return $config;
    }

    /**
     * Get formatted CSS link tags
     *
     * @return string
     */
    public static function getCssLinks(): string
    {
        $assets = self::getCssAssets();
        $html = '';

        foreach ($assets as $key => $path) {
            if ($key === 'fonts') {
                // Preload for fonts
                $html .= sprintf(
                    '<link rel="preload" href="%s" as="style" onload="this.rel=\'stylesheet\'">' . "\n",
                    asset($path)
                );
            } else {
                $html .= sprintf(
                    '<link rel="stylesheet" href="%s">' . "\n",
                    asset($path)
                );
            }
        }

        return $html;
    }

    /**
     * Get formatted JavaScript script tags
     *
     * @return string
     */
    public static function getJsScripts(): string
    {
        $assets = self::getJsAssets();
        $html = '';

        foreach ($assets as $path) {
            $html .= sprintf(
                '<script src="%s"></script>' . "\n",
                asset($path)
            );
        }

        return $html;
    }

    /**
     * Get full HTML structure for preview
     *
     * @param string $content The template HTML content
     * @param string $type The template type: 'header', 'footer', or 'section'
     * @return string
     */
    public static function getPreviewHtml(string $content, string $type = 'section'): string
    {
        $cssLinks = self::getCssLinks();
        $jsScripts = self::getJsScripts();
        $meta = config('template-preview.meta', []);

        $viewport = $meta['viewport'] ?? 'width=device-width, initial-scale=1';
        $charset = $meta['charset'] ?? 'utf-8';

        // Wrap content based on type
        $bodyContent = match($type) {
            'header' => $content,
            'footer' => $content,
            'section' => '<div class="container py-8">' . $content . '</div>',
            default => $content,
        };

        return <<<HTML
<!doctype html>
<html lang="tr">
<head>
    <meta charset="{$charset}">
    <meta name="viewport" content="{$viewport}">
    <title>Template Preview</title>
    {$cssLinks}
</head>
<body style="margin: 0; padding: 0;">
    {$bodyContent}
    {$jsScripts}
</body>
</html>
HTML;
    }
}

