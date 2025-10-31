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
     * Convert relative asset paths to absolute URLs in HTML content
     *
     * @param string $html The HTML content
     * @return string HTML with absolute URLs
     */
    public static function convertRelativePathsToAbsolute(string $html): string
    {
        // Base URL for assets
        $baseUrl = rtrim(url('/'), '/');
        
        // Pattern 1: Match attributes with relative paths (src, href, data-src, etc.)
        // Matches: src="assets/...", href="assets/...", data-src="assets/..."
        // Also matches: src="/assets/...", href="./assets/...", etc.
        $html = preg_replace_callback(
            '/(\s+(?:src|href|data-src|data-href|srcset|action|poster|background)\s*=\s*["\'])((?:(?:\.\/|\.\.\/)*)?(?:assets|html|images?|img|css|js|fonts?|media|uploads?)[\/\w\-\.]+)(["\'])/i',
            function ($matches) use ($baseUrl) {
                $path = $matches[2];
                
                // Skip if already absolute URL (http://, https://, //, data:, mailto:, etc.)
                if (preg_match('/^(https?:|\/\/|data:|mailto:|#|javascript:)/i', $path)) {
                    return $matches[0];
                }
                
                // Remove leading slash if exists (we'll add it via asset helper)
                $path = ltrim($path, '/');
                
                // Convert to absolute URL using Laravel's asset helper
                $absoluteUrl = asset($path);
                
                return $matches[1] . $absoluteUrl . $matches[3];
            },
            $html
        );
        
        // Pattern 2: Match CSS url() functions with relative paths
        // Matches: url('assets/...'), url("assets/..."), url(assets/...)
        $html = preg_replace_callback(
            '/url\s*\(\s*(["\']?)((?:(?:\.\/|\.\.\/)*)?(?:assets|html|images?|img|css|js|fonts?|media|uploads?)[\/\w\-\.]+)\1\s*\)/i',
            function ($matches) use ($baseUrl) {
                $path = $matches[2];
                
                // Skip if already absolute URL
                if (preg_match('/^(https?:|\/\/|data:)/i', $path)) {
                    return $matches[0];
                }
                
                // Remove leading slash
                $path = ltrim($path, '/');
                
                // Convert to absolute URL
                $absoluteUrl = asset($path);
                
                return 'url(' . $matches[1] . $absoluteUrl . $matches[1] . ')';
            },
            $html
        );
        
        // Pattern 3: Match inline style attributes with background-image or background
        // This is already covered by Pattern 2 (url()), but we ensure it works
        $html = preg_replace_callback(
            '/(style\s*=\s*["\'])([^"\']*)(["\'])/i',
            function ($matches) {
                // Process url() in style attribute
                return $matches[1] . preg_replace_callback(
                    '/url\s*\(\s*(["\']?)((?:(?:\.\/|\.\.\/)*)?(?:assets|html|images?|img|css|js|fonts?|media|uploads?)[\/\w\-\.]+)\1\s*\)/i',
                    function ($urlMatches) {
                        $path = $urlMatches[2];
                        if (preg_match('/^(https?:|\/\/|data:)/i', $path)) {
                            return $urlMatches[0];
                        }
                        $path = ltrim($path, '/');
                        $absoluteUrl = asset($path);
                        return 'url(' . $urlMatches[1] . $absoluteUrl . $urlMatches[1] . ')';
                    },
                    $matches[2]
                ) . $matches[3];
            },
            $html
        );
        
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
        $baseUrl = rtrim(url('/'), '/');

        // Convert relative paths to absolute URLs in content
        $content = self::convertRelativePathsToAbsolute($content);

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
    <base href="{$baseUrl}">
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

