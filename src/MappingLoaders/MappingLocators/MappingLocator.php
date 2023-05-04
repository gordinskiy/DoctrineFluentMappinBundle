<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators;

final class MappingLocator implements MappingLocatorInterface
{
    /**
     * @var string[]
     */
    protected array $directories;

    public function __construct(string ...$directories)
    {
        $this->directories = $directories;
    }

    /**
     * @inheritDoc
     */
    public function getAllMappers(): array
    {
        $entityMappers = [];

        foreach ($this->directories as $configDir) {
            $entityMappers = [...$entityMappers, ...$this->getAllMappersInDirectory($configDir)];
        }

        return $entityMappers;
    }

    private function getAllMappersInDirectory(string $configDir): array
    {
        $entityMappers = [];

        foreach (scandir($configDir) ?: [] as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $filePath = $configDir . DIRECTORY_SEPARATOR . $item;

            $entityMappers[] = $filePath;
        }

        return $entityMappers;
    }
}
