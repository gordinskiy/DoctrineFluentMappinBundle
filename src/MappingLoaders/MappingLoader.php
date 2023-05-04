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
    public function getAllEntityMappers(): array
    {
        $loadedClasses = [];

        foreach ($this->mappingLocator->getAllMappers() as $mappingFile) {
            require_once $mappingFile;

            $loadedClasses[] = basename($mappingFile, '.php');
        }

        $entityMappers = [];

        foreach (get_declared_classes() as $class) {
            if (in_array(Mapping::class, class_implements($class))) {
                $className = basename(str_replace('\\', '/', $class));
                if (in_array($className, $loadedClasses)) {
                    $entityMappers[] = $class;
                }
            }
        }

        return $entityMappers;
    }
}
