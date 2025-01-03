<?php

namespace ContentStash\Core\Policies;

use ContentStash\Core\Enums\ModelRolePermissionPrefix;
use ContentStash\Core\Helpers\ModelHelper;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BaseModelPolicy
{
    use HandlesAuthorization;

    /**
     * Get the permission by prefix and model.
     */
    public static function getPermission(string $prefix, string $model)
    {
        $modelPermissionName = ModelHelper::getModelPermissionName($model);

        return $prefix.' '.$modelPermissionName;
    }

    /**
     * Check if the user has the permission by prefix and model.
     */
    public function checkPermission(string $prefix, string $model): Response
    {
        return request()->userOrGuest()->can(self::getPermission($prefix, $model)) ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(string $model): Response
    {
        return $this->checkPermission(ModelRolePermissionPrefix::VIEW_ANY->value, $model);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(string $model, $resource): Response
    {
        return $this->checkPermission(ModelRolePermissionPrefix::VIEW->value, $model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(string $model): Response
    {
        return $this->checkPermission(ModelRolePermissionPrefix::CREATE->value, $model);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(string $model, $resource): Response
    {
        return $this->checkPermission(ModelRolePermissionPrefix::UPDATE->value, $model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(string $model, $resource): Response
    {
        return $this->checkPermission(ModelRolePermissionPrefix::DELETE->value, $model);
    }
}
