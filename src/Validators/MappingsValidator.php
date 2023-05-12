<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Validators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use LaravelDoctrine\Fluent\Mapping;

class MappingsValidator
{
    /**
     * @param string ...$mappingClasses
     *
     * @throws ConfigurationException
     */
    public static function isValid(string ...$mappingClasses): void
    {
        foreach ($mappingClasses as $class) {
            if (!class_exists($class)) {
                throw ConfigurationException::mappingClassNotExist($class);
            }

            if (!in_array(Mapping::class, class_implements($class))) {
                throw ConfigurationException::invalidMappingClass($class);
            }
        }
    }
}
