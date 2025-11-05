<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FooterTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class FooterTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FooterTemplate');
    }

    public function view(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('View:FooterTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FooterTemplate');
    }

    public function update(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('Update:FooterTemplate');
    }

    public function delete(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('Delete:FooterTemplate');
    }

    public function restore(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('Restore:FooterTemplate');
    }

    public function forceDelete(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('ForceDelete:FooterTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FooterTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FooterTemplate');
    }

    public function replicate(AuthUser $authUser, FooterTemplate $footerTemplate): bool
    {
        return $authUser->can('Replicate:FooterTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FooterTemplate');
    }

}