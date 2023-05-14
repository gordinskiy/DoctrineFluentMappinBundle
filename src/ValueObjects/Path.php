<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ValueObjects;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;

class Path
{
    public function __construct(
        protected readonly string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function withPrefix(string $prefix): self
    {
        if (str_starts_with($this->value, $prefix)) {
            return $this;
        }

        return new self($prefix . $this->value);
    }

    /**
     * @throws ConfigurationException
     */
    public function assertAsDirectory(): DirectoryPath
    {
        return new DirectoryPath($this->value);
    }

    public static function createCollection(string ...$values): array
    {
        return array_map(fn (string $value) => new self($value), $values);
    }
}
