<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators;

interface MappingLocatorInterface
{
    /**
     * @return string[]
     */
    public function findMappingFiles(string ...$directories): array;
}
