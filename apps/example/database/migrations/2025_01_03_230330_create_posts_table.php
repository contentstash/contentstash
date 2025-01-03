<?php

use ContentStash\Core\Enums\ModelRolePermissionPrefix;
use ContentStash\Core\Helpers\ModelHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });

        foreach (ModelRolePermissionPrefix::cases() as $prefix) {
            Permission::create(['name' => $prefix->value.' '.ModelHelper::getModelPermissionName('App\Models\Post')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');

        foreach (ModelRolePermissionPrefix::cases() as $prefix) {
            Permission::where('name', $prefix->value.' '.ModelHelper::getModelPermissionName('App\Models\Post'))->delete();
        }
    }
};
