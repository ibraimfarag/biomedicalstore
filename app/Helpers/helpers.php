<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;


function hasPermission($permission, $userId = null)
{
    $user = $userId ? User::find($userId) : Auth::user();

    if ($user) {
        // Get the user's department
        $department = $user->department;

        // If the user does not belong to any department, return false
        if (!$department) {
            return false;
        }

        // Get all roles associated with the department
        $roles = $department->roles;

        // Flatten the roles to get all permissions
        $permissions = $roles->flatMap->permissions;

        // Check if the permission exists in the permissions collection
        return $permissions->contains('name', $permission);
    }

    return false;
}

