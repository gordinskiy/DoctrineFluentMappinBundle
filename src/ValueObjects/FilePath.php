<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\ValueObjects;

final class FilePath
{
    public function __construct(
        private readonly string $fileName,
        private readonly DirectoryPath $directory,
    ) {
    }

    /**
     * @param DirectoryPath $directory
     * @param string ...$fileNames
     *
     * @return self[]
     */
    public static function createCollection(DirectoryPath $directory, string ...$fileNames): array
    {
        return array_map(fn (string $fileName) => new self($fileName, $directory), $fileNames);
    }

    public function hasPhpExtension(): bool
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION) === 'php';
    }

    public function nameWithoutExtension(): string
    {
        return basename($this->fileName, '.php');
    }

    public function __toString(): string
    {
        return $this->directory->getValue() . DIRECTORY_SEPARATOR . $this->fileName;
    }
}
