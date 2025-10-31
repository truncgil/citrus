<?php

namespace App\Http\Controllers;

use App\Services\TemplatePreviewService;
use Illuminate\Http\Request;

class TemplatePreviewController extends Controller
{
    /**
     * Render template preview
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function preview(Request $request)
    {
        $content = $request->input('content', '');
        $type = $request->input('type', 'section'); // header, footer, section

        // Validate type
        if (!in_array($type, ['header', 'footer', 'section'])) {
            $type = 'section';
        }

        $html = TemplatePreviewService::getPreviewHtml($content, $type);

        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}

