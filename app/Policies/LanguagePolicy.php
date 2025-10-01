<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Language $language): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Language $language): bool
    {
        // Cannot disable default language
        if ($language->is_default && !$user->hasRole('super_admin')) {
            return false;
        }

        return $user->hasRole('super_admin') || $user->can('language::update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Language $language): bool
    {
        // Cannot delete default language
        if ($language->is_default) {
            return false;
        }

        return $user->hasRole('super_admin') || $user->can('language::delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Language $language): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Language $language): bool
    {
        // Cannot force delete default language
        if ($language->is_default) {
            return false;
        }

        return $user->hasRole('super_admin') || $user->can('language::forceDelete');
    }

    /**
     * Determine whether the user can activate the language.
     */
    public function activate(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::activate');
    }

    /**
     * Determine whether the user can set the language as default.
     */
    public function setDefault(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->can('language::setDefault');
    }
}
