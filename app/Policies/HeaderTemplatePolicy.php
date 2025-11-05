<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HeaderTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class HeaderTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HeaderTemplate');
    }

    public function view(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('View:HeaderTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HeaderTemplate');
    }

    public function update(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('Update:HeaderTemplate');
    }

    public function delete(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('Delete:HeaderTemplate');
    }

    public function restore(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('Restore:HeaderTemplate');
    }

    public function forceDelete(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('ForceDelete:HeaderTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HeaderTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HeaderTemplate');
    }

    public function replicate(AuthUser $authUser, HeaderTemplate $headerTemplate): bool
    {
        return $authUser->can('Replicate:HeaderTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HeaderTemplate');
    }

}