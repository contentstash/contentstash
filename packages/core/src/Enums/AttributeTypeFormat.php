<?php

namespace ContentStash\Core\Enums;

enum AttributeTypeFormat: string
{
    case Date = 'DATE';
    case DateTime = 'DATETIME';
    case Raw = 'RAW';
    case Time = 'TIME';
}
