<?php

declare(strict_types=1);

namespace App\Service\DatabaseManager;

interface DatabaseManagerInterface
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public static function getType(): string;

    public function bulkUpdate(array $entities): void;

    public function list(string $entityClass): array;
}
