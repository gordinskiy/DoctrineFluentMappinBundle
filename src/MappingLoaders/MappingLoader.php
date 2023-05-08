<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocatorInterface;
use LaravelDoctrine\Fluent\Mapping;

final class MappingLoader
{
    public function __construct(
        private readonly MappingLocatorInterface $mappingLocator
    ) {
    }

    /**
     * @return string[]
     * @throws ConfigurationException
     * @throws \ReflectionException
     */
    public function getAllEntityMappers(): array
    {
        $loadedClasses = [];

        $mappingFiles = $this->mappingLocator->getAllMappers();

        foreach ($mappingFiles as $mappingFile) {
            require_once $mappingFile;

            $loadedClasses[] = basename($mappingFile, '.php');
        }

        $entityMappers = [];

        foreach (get_declared_classes() as $class) {
            $className = basename(str_replace('\\', '/', $class));

            if (in_array($className, $loadedClasses)) {
                $reflection = new \ReflectionClass($class);

                if (in_array($reflection->getFileName(), $mappingFiles)) {
                    if (!$reflection->implementsInterface(Mapping::class)) {
                        throw ConfigurationException::mappingWithoutInterface($class);
                    }

                    $entityMappers[] = $class;
                }
            }
        }

        return $entityMappers;
    }
}
