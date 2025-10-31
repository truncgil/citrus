<?php

namespace App\View\Components;

use App\Models\Page;
use App\Services\TemplateService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageRenderer extends Component
{
    public Page $page;

    /**
     * Create a new component instance.
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-renderer');
    }

    /**
     * Render the header template with data
     */
    public function renderHeader(): string
    {
        if (!$this->page->headerTemplate) {
            return '';
        }

        return TemplateService::replacePlaceholders(
            $this->page->headerTemplate->html_content,
            $this->page->header_data ?? []
        );
    }

    /**
     * Render all sections with their templates
     */
    public function renderSections(): string
    {
        $output = '';

        foreach ($this->page->templated_sections as $section) {
            if (!$section['template']) {
                continue;
            }

            $output .= TemplateService::replacePlaceholders(
                $section['template']->html_content,
                $section['data']
            );
        }

        return $output;
    }

    /**
     * Render the footer template with data
     */
    public function renderFooter(): string
    {
        if (!$this->page->footerTemplate) {
            return '';
        }

        return TemplateService::replacePlaceholders(
            $this->page->footerTemplate->html_content,
            $this->page->footer_data ?? []
        );
    }
}
