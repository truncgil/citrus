<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'language_code',
        'field_name',
        'field_value',
        'status',
        'version',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
        'published_at',
    ];

    protected $casts = [
        'version' => 'integer',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scopes
     */
    public function scopeForModel($query, string $modelClass, int $modelId)
    {
        return $query->where('translatable_type', $modelClass)
            ->where('translatable_id', $modelId);
    }

    public function scopeForLanguage($query, string $languageCode)
    {
        return $query->where('language_code', $languageCode);
    }

    public function scopeForField($query, string $fieldName)
    {
        return $query->where('field_name', $fieldName);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['approved', 'published']);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeReview($query)
    {
        return $query->where('status', 'review');
    }

    public function scopePendingApproval($query)
    {
        return $query->whereIn('status', ['draft', 'review']);
    }

    /**
     * Workflow Methods
     */
    public function submitForReview(): bool
    {
        if ($this->status === 'draft') {
            $this->status = 'review';
            return $this->save();
        }
        return false;
    }

    public function approve(?int $userId = null): bool
    {
        if (in_array($this->status, ['draft', 'review'])) {
            $this->status = 'approved';
            $this->approved_by = $userId ?? auth()->id();
            $this->approved_at = now();
            return $this->save();
        }
        return false;
    }

    public function publish(?int $userId = null): bool
    {
        if (in_array($this->status, ['approved', 'draft', 'review'])) {
            $this->status = 'published';
            $this->published_at = now();
            if (!$this->approved_by) {
                $this->approved_by = $userId ?? auth()->id();
                $this->approved_at = now();
            }
            return $this->save();
        }
        return false;
    }

    public function reject(): bool
    {
        if ($this->status === 'review') {
            $this->status = 'draft';
            return $this->save();
        }
        return false;
    }

    public function unpublish(): bool
    {
        if ($this->status === 'published') {
            $this->status = 'approved';
            $this->published_at = null;
            return $this->save();
        }
        return false;
    }

    /**
     * Helper Methods
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isReview(): bool
    {
        return $this->status === 'review';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft', 'review']);
    }

    public function canBeApproved(): bool
    {
        return in_array($this->status, ['draft', 'review']);
    }

    public function canBePublished(): bool
    {
        return in_array($this->status, ['draft', 'review', 'approved']);
    }
}
