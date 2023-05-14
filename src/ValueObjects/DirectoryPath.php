<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ValueObjects;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;

final class DirectoryPath extends Path
{
    /**
     * @throws ConfigurationException
     */
    public function __construct(string $value)
    {
        parent::__construct($value);

        if (!is_dir($value)) {
            if (!file_exists($value)) {
                throw ConfigurationException::directoryNotFound($value);
            }

            throw ConfigurationException::notDirectory($value);
        }
    }
}
