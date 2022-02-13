<?php
namespace App\Traits;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Support\Facades\Auth;

trait CheckPermission
{
    /**
     * Check if the user has the permission.
     **/
    public function checkPermission(string $permissionName)
    {
        if (!Auth::user()->hasPermissionTo($permissionName)) {
            throw new AccessDeniedException("You have not the permission to view this page", 403);
        }
    }

    /**
    * Check the permission and also allows the owner of the model.
    **/
    public function checkPermissionAllowOwner(string $permissionName, $entity)
    {
        if (!property_exists($entity, 'user_id')) {
            throw new AccessDeniedException("The user can't be owner of this resource.", 403);
        }

        $userId = $entity->user_id ?? 'none';
        if (!( Auth::user()->hasPermissionTo($permissionName) || Auth::id() === $userId)) {
            throw new AccessDeniedException("You have not the permission to view this page.", 403);
        }
    }

}
