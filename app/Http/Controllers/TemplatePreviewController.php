<?php

namespace App\Http\Controllers;

use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Models\SectionTemplate;
use App\Services\TemplatePreviewService;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class TemplatePreviewController extends Controller
{
    /**
     * Render template preview
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $recordId = $request->input('record_id');
        $type = $request->input('type', 'section'); // header, footer, section

        // Validate type
        if (!in_array($type, ['header', 'footer', 'section'])) {
            $type = 'section';
        }

        // Get template and its default data
        $content = '';
        $defaultData = [];
        
        if ($recordId) {
            $template = $this->getTemplate($recordId, $type);
            if ($template) {
                $content = $template->html_content ?? '';
                $defaultData = $template->default_data ?? [];
            }
        } else {
            // Fallback: eski yöntem (content gönderimi)
            $content = $request->input('content', '');
        }

        if (empty($content)) {
            return response('No content to preview', 400);
        }

        // Replace placeholders with default data
        if (!empty($defaultData)) {
            $content = TemplateService::replacePlaceholders($content, $defaultData);
        }

        $html = TemplatePreviewService::getPreviewHtml($content, $type);

        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Get template object from database by ID
     *
     * @param int $id
     * @param string $type
     * @return object|null
     */
    private function getTemplate(int $id, string $type): ?object
    {
        return match($type) {
            'header' => HeaderTemplate::find($id),
            'footer' => FooterTemplate::find($id),
            'section' => SectionTemplate::find($id),
            default => null,
        };
    }
}

