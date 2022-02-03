<?php
namespace App\Traits;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Support\Facades\Auth;

trait CheckPermission
{
    public function checkPermission(string $permissionName)
    {
        if (!Auth::user()->hasPermissionTo($permissionName)) {
            throw new AccessDeniedException("You have not the permission to view this page", 403);
        }
    }

    /**
    * Check permission and also allows the owner of the model.
    **/
    public function checkPermissionAllowOwner(string $permissionName, $entity)
    {
        $userId = $entity->user_id ?? 'none';
        
        if (!( Auth::user()->hasPermissionTo($permissionName) || Auth::id() === $userId)) {
            throw new AccessDeniedException("You have not the permission to view this page", 403);
        }
    }



}
