<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;

final class MappingLocator implements MappingLocatorInterface
{
    public function findMappingFiles(...$directories): array
    {
        $entityMappings = [];

        foreach ($directories as $configDir) {
            $entityMappings = [...$entityMappings, ...$this->findMappingFilesInDirectory($configDir)];
        }

        return $entityMappings;
    }

    /**
     * @param string $configDir
     * @return string[]
     * @throws ConfigurationException
     */
    private function findMappingFilesInDirectory(string $configDir): array
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
