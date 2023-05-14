<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\FileSystem\FileSystem;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\DirectoryPath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\FilePath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\Path;

final class MappingLocator implements MappingLocatorInterface
{
    /**
     * @return FilePath[]
     * @throws ConfigurationException
     */
    public function findMappingFiles(Path ...$directories): array
    {
        $entityMappings = [];

        foreach ($directories as $configDir) {
            $entityMappings = [
                ...$entityMappings,
                ...$this->findMappingFilesInDirectory($configDir->assertAsDirectory()),
            ];
        }

        return $entityMappings;
    }

    /**
     * @param DirectoryPath $configDir
     * @return FilePath[]
     * @throws ConfigurationException
     */
    private function findMappingFilesInDirectory(DirectoryPath $configDir): array
    {
        $entityMappingFilePaths = [];

        // TODO: Use array_map instead of foreach
        foreach ((new FileSystem)->getFilesInDirectory($configDir) ?: [] as $filePath) {
            if ($filePath->hasPhpExtension()) {
                $entityMappingFilePaths[] = $filePath;
            }
        }

        if (empty($entityMappingFilePaths)) {
            // TODO: Replace string in exception Argument with DirectoryPath
            throw ConfigurationException::mappingsNotFound($configDir->getValue());
        }

        return $entityMappingFilePaths;
    }
}
