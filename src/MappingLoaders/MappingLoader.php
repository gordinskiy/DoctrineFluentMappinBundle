<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders;

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
     */
    public function getAllEntityMappings(): array
    {
        $loadedClasses = [];
        $mappingFiles = $this->mappingLocator->getAllMappings();

        foreach ($mappingFiles as $mappingFile) {
            require_once $mappingFile;

            $loadedClasses[] = basename($mappingFile, '.php');
        }

        $entityMappings = [];

        foreach (get_declared_classes() as $class) {
            if (in_array(Mapping::class, class_implements($class))) {
                $className = basename(str_replace('\\', '/', $class));

                if (in_array($className, $loadedClasses)) {
                    $reflection = new \ReflectionClass($class);

                    if (in_array($reflection->getFileName(), $mappingFiles)) {
                        $entityMappings[] = $class;
                    }
                }
            }
        }

        return $entityMappings;
    }
}
