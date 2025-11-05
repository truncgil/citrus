<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MenuTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MenuTemplate');
    }

    public function view(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('View:MenuTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MenuTemplate');
    }

    public function update(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('Update:MenuTemplate');
    }

    public function delete(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('Delete:MenuTemplate');
    }

    public function restore(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('Restore:MenuTemplate');
    }

    public function forceDelete(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('ForceDelete:MenuTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MenuTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MenuTemplate');
    }

    public function replicate(AuthUser $authUser, MenuTemplate $menuTemplate): bool
    {
        return $authUser->can('Replicate:MenuTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MenuTemplate');
    }

}