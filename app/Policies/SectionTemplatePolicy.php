<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SectionTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SectionTemplate');
    }

    public function view(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('View:SectionTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SectionTemplate');
    }

    public function update(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('Update:SectionTemplate');
    }

    public function delete(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('Delete:SectionTemplate');
    }

    public function restore(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('Restore:SectionTemplate');
    }

    public function forceDelete(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('ForceDelete:SectionTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SectionTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SectionTemplate');
    }

    public function replicate(AuthUser $authUser, SectionTemplate $sectionTemplate): bool
    {
        return $authUser->can('Replicate:SectionTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SectionTemplate');
    }

}