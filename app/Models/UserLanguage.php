<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_code',
        'can_create',
        'can_edit',
        'can_approve',
        'can_publish',
    ];

    protected $casts = [
        'can_create' => 'boolean',
        'can_edit' => 'boolean',
        'can_approve' => 'boolean',
        'can_publish' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    /**
     * Scopes
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForLanguage($query, string $languageCode)
    {
        return $query->where('language_code', $languageCode);
    }

    public function scopeCanCreate($query)
    {
        return $query->where('can_create', true);
    }

    public function scopeCanEdit($query)
    {
        return $query->where('can_edit', true);
    }

    public function scopeCanApprove($query)
    {
        return $query->where('can_approve', true);
    }

    public function scopeCanPublish($query)
    {
        return $query->where('can_publish', true);
    }

    /**
     * Helper Methods
     */
    public function hasFullAccess(): bool
    {
        return $this->can_create && $this->can_edit && $this->can_approve && $this->can_publish;
    }

    public function hasNoAccess(): bool
    {
        return !$this->can_create && !$this->can_edit && !$this->can_approve && !$this->can_publish;
    }

    public function grantFullAccess(): bool
    {
        $this->can_create = true;
        $this->can_edit = true;
        $this->can_approve = true;
        $this->can_publish = true;
        return $this->save();
    }

    public function revokeAllAccess(): bool
    {
        $this->can_create = false;
        $this->can_edit = false;
        $this->can_approve = false;
        $this->can_publish = false;
        return $this->save();
    }
}
