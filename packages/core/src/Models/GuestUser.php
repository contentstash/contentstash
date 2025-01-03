<?php

namespace ContentStash\Core\Models;

use ContentStash\Core\Enums\UserRole;
use Spatie\Permission\Models\Role;

class GuestUser
{
    /**
     * Returns the role names of the guest user.
     */
    public function getRoleNames(): \Illuminate\Support\Collection
    {
        return collect([UserRole::EVERYONE->value, UserRole::GUEST->value]);
    }

    /**
     * Returns true if the guest user has the given permission.
     */
    public function can($permission): bool
    {
        $guestRoles = $this->getRoleNames();
        foreach ($guestRoles as $role) {
            if (Role::findByName($role)->hasPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns all permissions of the guest user.
     */
    public function getAllPermissions(): \Illuminate\Support\Collection
    {
        $guestRoles = $this->getRoleNames();
        $permissions = collect();

        $tmp = [];
        foreach ($guestRoles as $role) {
            $tmp[] = Role::findByName($role);
            $permissions = $permissions->merge(Role::findByName($role)->permissions);
        }

        return $permissions;
    }
}
