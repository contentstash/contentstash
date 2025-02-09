<?php

namespace Database\Seeders;

use App\Models\Post;
use ContentStash\Core\Enums\ModelRolePermissionPrefix;
use ContentStash\Core\Enums\UserRole;
use ContentStash\Core\Helpers\ModelHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(1000)->create();

        // get view, viewAny, create, update and delete permissions for the Post model
        $viewPost = Permission::where('name', ModelRolePermissionPrefix::VIEW->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->first();
        $viewAnyPost = Permission::where('name', ModelRolePermissionPrefix::VIEW_ANY->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->first();
        $createPost = Permission::where('name', ModelRolePermissionPrefix::CREATE->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->first();
        $updatePost = Permission::where('name', ModelRolePermissionPrefix::UPDATE->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->first();
        $deletePost = Permission::where('name', ModelRolePermissionPrefix::DELETE->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->first();

        // asign to everyone role
        $everyone = Role::findByName(UserRole::EVERYONE->value, 'web');
        $everyone->givePermissionTo($viewPost);
        $everyone->givePermissionTo($viewAnyPost);
        $everyone->givePermissionTo($createPost);
        $everyone->givePermissionTo($updatePost);
        $everyone->givePermissionTo($deletePost);
    }
}
