<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function userLanguages(): HasMany
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_languages', 'user_id', 'language_code', 'id', 'code')
            ->withPivot(['can_create', 'can_edit', 'can_approve', 'can_publish'])
            ->withTimestamps();
    }

    /**
     * Language Management Methods
     */
    public function canManageLanguage(string $languageCode): bool
    {
        // Super admin can manage all languages
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->where(function ($query) {
                $query->where('can_create', true)
                    ->orWhere('can_edit', true)
                    ->orWhere('can_approve', true)
                    ->orWhere('can_publish', true);
            })
            ->exists();
    }

    public function canCreateInLanguage(string $languageCode): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->where('can_create', true)
            ->exists();
    }

    public function canEditInLanguage(string $languageCode): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->where('can_edit', true)
            ->exists();
    }

    public function canApproveInLanguage(string $languageCode): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->where('can_approve', true)
            ->exists();
    }

    public function canPublishInLanguage(string $languageCode): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->where('can_publish', true)
            ->exists();
    }

    public function getManagedLanguages(): \Illuminate\Support\Collection
    {
        return $this->userLanguages()
            ->with('language')
            ->get()
            ->pluck('language');
    }

    public function getManagedLanguageCodes(): array
    {
        return $this->userLanguages()
            ->pluck('language_code')
            ->toArray();
    }

    public function assignLanguage(
        string $languageCode, 
        bool $canCreate = true, 
        bool $canEdit = true, 
        bool $canApprove = false, 
        bool $canPublish = false
    ): UserLanguage {
        return $this->userLanguages()->updateOrCreate(
            ['language_code' => $languageCode],
            [
                'can_create' => $canCreate,
                'can_edit' => $canEdit,
                'can_approve' => $canApprove,
                'can_publish' => $canPublish,
            ]
        );
    }

    public function removeLanguage(string $languageCode): bool
    {
        return $this->userLanguages()
            ->where('language_code', $languageCode)
            ->delete() > 0;
    }
}
