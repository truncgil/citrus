<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Template Preview Asset Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains all asset paths that should be loaded
    | in the template preview iframe. These assets are used to ensure the
    | preview displays correctly with the same styling and scripts as the
    | actual site.
    |
    | You can override these values in Settings table if needed, or modify
    | this config file for project-specific asset paths.
    |
    */

    // CSS Assets (Stylesheets)
    'css' => [
        'style' => 'html/style.css',
        'unicons' => 'assets/fonts/unicons/unicons.css',
        'plugins' => 'assets/css/plugins.css',
        'colors' => 'assets/css/colors/grape.css',
        'fonts' => 'assets/css/fonts/urbanist.css',
    ],

    // JavaScript Assets
    'js' => [
        'plugins' => 'assets/js/plugins.js',
        'theme' => 'assets/js/theme.js',
    ],

    // Additional meta tags and head content
    'meta' => [
        'viewport' => 'width=device-width, initial-scale=1',
        'charset' => 'utf-8',
    ],

    // Whether to load assets from Settings table (overrides config)
    'use_settings_override' => false,

    // Settings keys for asset paths (if use_settings_override is true)
    'settings_keys' => [
        'css_style' => 'template_preview_css_style',
        'css_unicons' => 'template_preview_css_unicons',
        'css_plugins' => 'template_preview_css_plugins',
        'css_colors' => 'template_preview_css_colors',
        'css_fonts' => 'template_preview_css_fonts',
        'js_plugins' => 'template_preview_js_plugins',
        'js_theme' => 'template_preview_js_theme',
    ],
];

