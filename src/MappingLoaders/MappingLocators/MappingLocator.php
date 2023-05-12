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
    public function getAllMappings(): array
    {
        $entityMappings = [];

        foreach ($this->directories as $configDir) {
            $entityMappings = [...$entityMappings, ...$this->getAllMappingsInDirectory($configDir)];
        }

        return $entityMappings;
    }

    /**
     * @param string $configDir
     * @return string[]
     * @throws ConfigurationException
     */
    private function getAllMappingsInDirectory(string $configDir): array
    {
        $entityMappings = [];

        if (!file_exists($configDir)) {
            throw ConfigurationException::directoryNotFound($configDir);
        }

        foreach (scandir($configDir) ?: [] as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            if (pathinfo($item, PATHINFO_EXTENSION) === 'php') {
                $entityMappings[] = $configDir . DIRECTORY_SEPARATOR . $item;
            }
        }

        if (empty($entityMappings)) {
            throw ConfigurationException::mappingsNotFound($configDir);
        }

        return $entityMappings;
    }
}
