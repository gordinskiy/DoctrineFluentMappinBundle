<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\Path;

interface MappingLocatorInterface
{
    /**
     * @return string[]
     */
    public function findMappingFiles(Path ...$directories): array;
}
