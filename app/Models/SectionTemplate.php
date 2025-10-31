<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'html_content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Section templates are used via JSON in pages.sections_data
     * No direct relation needed, but we can add a helper method
     */
    public function getPagesUsingThisTemplate()
    {
        return Page::whereJsonContains('sections_data', [['section_template_id' => $this->id]])->get();
    }
}
