<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Exceptions;

use Exception;

class ConfigurationException extends Exception
{
    public static function mappingsNotConfigured(): self
    {
        return new self(
            message: "At least one mapping or mapping path must be configured"
        );
    }

    public static function directoryNotFound(string $configDir): self
    {
        return new self(
            message: "Mapping directory does not exist [$configDir]"
        );
    }

    public static function mappersNotFound(string $configDir): self
    {
        return new self(
            message: "Mapping directory is empty [$configDir]"
        );
    }
}
