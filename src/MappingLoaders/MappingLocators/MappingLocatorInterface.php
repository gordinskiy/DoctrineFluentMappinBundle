<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators;

interface MappingLocatorInterface
{
    /**
     * @return string[]
     */
    public function getAllMappers(): array;
}
