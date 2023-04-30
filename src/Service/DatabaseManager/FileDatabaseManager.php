<?php

declare(strict_types=1);

namespace App\Service\DatabaseManager;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class FileDatabaseManager implements DatabaseManagerInterface
{
    /**
     * @var string|mixed
     */
    private string $filePath;

    /**
     * @return string
     */
    abstract public static function getType(): string;

    public function __construct(string $databaseDSN, private readonly SerializerInterface $serializer)
    {
        $this->filePath = $databaseDSN;
    }

    public function bulkUpdate(array $entities): void
    {
        file_put_contents(
            $this->filePath,
            $this->serializer->serialize($entities, static::getType(), [
                DateTimeNormalizer::FORMAT_KEY => self::DATE_TIME_FORMAT,
            ])
        );
    }

    public function list(string $entityClass): array
    {
        $dbFileContent = file_get_contents($this->filePath);

        return $this->serializer->deserialize($dbFileContent, $entityClass . '[]', static::getType());
    }
}
