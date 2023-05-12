<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Exceptions;

use Exception;
use LaravelDoctrine\Fluent\Mapping;

class ConfigurationException extends Exception
{
    public static function mappingsNotConfigured(): self
    {
        return new self(
            message: "No mappings or mappings paths provided"
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

    public static function invalidMappingClass(string $mappingCLass): self
    {
        return new self(
            message: "Mapping class [$mappingCLass] must implement " . Mapping::class
        );
    }

    public static function mappingClassNotExist(string $mappingCLass): self
    {
        return new self(
            message: "Mapping class [$mappingCLass] not exist"
        );
    }
}
