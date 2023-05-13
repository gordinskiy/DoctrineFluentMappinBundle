<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use LaravelDoctrine\Fluent\Mapping;

final class MappingProcessor
{
    /** @var string[] */
    private readonly array $mappingClasses;

    public function __construct(string ...$mappingClasses)
    {
        $this->mappingClasses = $mappingClasses;
    }

    /**
     * @return string[]
     * @throws ConfigurationException
     */
    public function getMappings(): array
    {
        foreach ($this->mappingClasses as $class) {
            if (!class_exists($class)) {
                throw ConfigurationException::mappingClassNotExist($class);
            }

            if (!in_array(Mapping::class, class_implements($class))) {
                throw ConfigurationException::invalidMappingClass($class);
            }
        }

        return $this->mappingClasses;
    }
}
