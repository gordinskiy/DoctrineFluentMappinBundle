<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders\MappingDirectoriesLoader;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocator;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocatorInterface;
use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\Path;

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
     * @throws ConfigurationException
     */
    public function process(string ...$mappingsPaths): array
    {
        $directories = array_map(
            fn (Path $path) => $path->withPrefix(DIRECTORY_SEPARATOR)->withPrefix($this->rootDir),
            Path::createCollection(...$mappingsPaths)
        );

        return $this->mappingLoader->loadMappings(
            ...($this->mappingLocator)->findMappingFiles(
                ...$directories
            )
        );
    }
}
