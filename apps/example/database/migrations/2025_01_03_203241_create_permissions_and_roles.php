<?php

use ContentStash\Core\Enums\RolePermission;
use ContentStash\Core\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => UserRole::EVERYONE, 'is_system' => true]);
        Role::create(['name' => UserRole::GUEST, 'is_system' => true]);
        Role::create(['name' => UserRole::USER, 'is_system' => true]);
        $admin = Role::create(['name' => UserRole::ADMIN, 'is_system' => true]);

        $viewDashboard = Permission::create(['name' => RolePermission::VIEW_DASHBOARD]);
        $admin->givePermissionTo($viewDashboard);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::where('name', UserRole::EVERYONE)->delete();
        Role::where('name', UserRole::GUEST)->delete();
        Role::where('name', UserRole::USER)->delete();
        Role::where('name', UserRole::ADMIN)->delete();

        Permission::where('name', RolePermission::VIEW_DASHBOARD)->delete();
    }
};
