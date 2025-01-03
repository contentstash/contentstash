<?php

namespace ContentStash\Core\Enums;

enum ModelRolePermissionPrefix: string
{
    case LIST = 'list';
    case SHOW = 'show';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
