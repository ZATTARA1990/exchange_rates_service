<?php

declare(strict_types=1);

namespace App\Service\DatabaseManager;

class JsonDatabaseManager extends FileDatabaseManager
{
    public static function getType(): string
    {
        return 'json';
    }
}
