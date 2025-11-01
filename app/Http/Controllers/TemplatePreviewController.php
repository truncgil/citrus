<?php

namespace App\Http\Controllers;

use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Models\SectionTemplate;
use App\Services\TemplatePreviewService;
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

        // ID varsa veritabanından çek, yoksa eskisi gibi çalış
        $content = '';
        if ($recordId) {
            $content = $this->getTemplateContent($recordId, $type);
        } else {
            // Fallback: eski yöntem (content gönderimi)
            $content = $request->input('content', '');
        }

        if (empty($content)) {
            return response('No content to preview', 400);
        }

        $html = TemplatePreviewService::getPreviewHtml($content, $type);

        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Get template content from database by ID
     *
     * @param int $id
     * @param string $type
     * @return string
     */
    private function getTemplateContent(int $id, string $type): string
    {
        return match($type) {
            'header' => HeaderTemplate::find($id)?->html_content ?? '',
            'footer' => FooterTemplate::find($id)?->html_content ?? '',
            'section' => SectionTemplate::find($id)?->html_content ?? '',
            default => '',
        };
    }
}

