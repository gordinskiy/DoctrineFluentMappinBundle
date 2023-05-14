<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\FileSystem;

use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\DirectoryPath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\FilePath;

class FileSystem
{
    /**
     * @return FilePath[]
     */
    public function getFilesInDirectory(DirectoryPath $directory): array
    {
        $directoryItems = scandir($directory->getValue());

        if ($directoryItems === false) {
            return [];
        }

        $files = array_filter($directoryItems, fn (string $file) => !in_array($file, ['.', '..']));

        return FilePath::createCollection($directory, ...$files);
    }
}
