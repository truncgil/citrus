<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterTemplate extends Model
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
     * Get the pages that use this footer template.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'footer_template_id');
    }
}
