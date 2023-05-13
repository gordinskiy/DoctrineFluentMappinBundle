<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders\MappingDirectoriesLoader;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocator;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocatorInterface;

final class MappingsPathsProcessor
{
    private readonly MappingLocatorInterface $mappingLocator;
    private readonly MappingDirectoriesLoader $mappingLoader;

    public function __construct(
        private readonly string $rootDir
    ) {
        $this->mappingLoader = new MappingDirectoriesLoader();
        $this->mappingLocator = new MappingLocator();
    }

    /**
     * @return string[]
     */
    public function process(string ...$mappingsPaths): array
    {
        $directories = [];

        foreach ($mappingsPaths as $mappingsPath) {
            if (!str_starts_with($mappingsPath, $this->rootDir)) {
                if (!str_starts_with($mappingsPath, DIRECTORY_SEPARATOR)) {
                    $mappingsPath = DIRECTORY_SEPARATOR . $mappingsPath;
                }

                $mappingsPath = $this->rootDir . $mappingsPath;
            }

            $directories[] = $mappingsPath;
        }

        return $this->mappingLoader->loadMappings(
            ...($this->mappingLocator)->findMappingFiles(
                ...$directories
            )
        );
    }
}
