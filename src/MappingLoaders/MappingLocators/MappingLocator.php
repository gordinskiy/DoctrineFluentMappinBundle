<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;

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

    /**
     * @param string $configDir
     * @return string[]
     * @throws ConfigurationException
     */
    private function getAllMappersInDirectory(string $configDir): array
    {
        $entityMappers = [];

        if (!file_exists($configDir)) {
            throw ConfigurationException::directoryNotFound($configDir);
        }

        foreach (scandir($configDir) ?: [] as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $filePath = $configDir . DIRECTORY_SEPARATOR . $item;

            $entityMappers[] = $filePath;
        }

        if (empty($entityMappers)) {
            throw ConfigurationException::mappersNotFound($configDir);
        }

        return $entityMappers;
    }
}
