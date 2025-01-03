<?php

namespace ContentStash\Core\Enums;

enum UserRole: string
{
    case EVERYONE = 'everyone';
    case GUEST = 'guest';
    case USER = 'user';
    case ADMIN = 'admin';
}
