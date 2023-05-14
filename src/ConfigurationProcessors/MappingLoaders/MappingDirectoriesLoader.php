<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders;

use LaravelDoctrine\Fluent\Mapping;

final class MappingDirectoriesLoader
{
    /**
     * @param string ...$mappingFiles
     * @return string[]
     */
    public function loadMappings(string ...$mappingFiles): array
    {
        $loadedClasses = [];

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
