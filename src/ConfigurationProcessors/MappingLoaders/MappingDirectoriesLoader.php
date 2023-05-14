<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\FilePath;
use LaravelDoctrine\Fluent\Mapping;

final class MappingDirectoriesLoader
{
    /**
     * @param FilePath ...$mappingFiles
     * @return string[]
     */
    public function loadMappings(FilePath ...$mappingFiles): array
    {
        $loadedClasses = [];

        $indexedMappingFiles = [];

        foreach ($mappingFiles as $mappingFile) {
            require_once (string) $mappingFile;

            $indexedMappingFiles[(string) $mappingFile] = $mappingFile;
            $loadedClasses[] = $mappingFile->nameWithoutExtension();
        }

        $entityMappings = [];

        foreach (get_declared_classes() as $class) {
            if (in_array(Mapping::class, class_implements($class))) {
                $className = basename(str_replace('\\', '/', $class));

                if (in_array($className, $loadedClasses)) {
                    $reflection = new \ReflectionClass($class);

                    if (array_key_exists($reflection->getFileName(), $indexedMappingFiles)) {
                        $entityMappings[] = $class;
                    }
                }
            }
        }

        return $entityMappings;
    }
}
