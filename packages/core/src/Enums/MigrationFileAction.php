<?php

namespace ContentStash\Core\Enums;

enum MigrationFileAction: string
{
    case Create = 'CREATE';
    case Update = 'UPDATE';
    case Delete = 'DELETE';
}
