<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocator;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\DirectoryPath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\FilePath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\Path;
use PHPUnit\Framework\TestCase;

class MappingLocatorTest extends TestCase
{
    public function test_directory_with_mappings(): void
    {
        $projectRoot = dirname(__DIR__, 3);
        $locator = new MappingLocator();

        $directory = new DirectoryPath($projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings');

        self::assertEquals(
            expected: $locator->findMappingFiles($directory),
            actual: [
                new FilePath('OrderMapping.php', $directory),
                new FilePath('ProductMapping.php', $directory),
                new FilePath('UserMapping.php', $directory),
            ]
        );
    }

    public function test_nested_directory_with_mappings(): void
    {
        $testsRoot = dirname(__DIR__, 3);
        $locator = new MappingLocator();

        $directory = new DirectoryPath($testsRoot . '/Fixtures/Mappings/NestedDirectoriesWithMappings');

        self::assertEquals(
            expected: $locator->findMappingFiles($directory),
            actual: [
                new FilePath('UserMapping.php', $directory),
            ]
        );
    }

    public function test_without_paths(): void
    {
        $locator = new MappingLocator();

        self::assertEmpty($locator->findMappingFiles());
    }

    public function test_with_wrong_path(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory does not exist [wrong_path]");

        $locator = new MappingLocator();

        $locator->findMappingFiles(new Path('wrong_path'));
    }

    public function test_with_file_path(): void
    {
        $testsRoot = dirname(__DIR__, 3);
        $pathToFile = $testsRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings/UserMapping.php';

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping path must be a directory [$pathToFile]");

        $locator = new MappingLocator();
        $locator->findMappingFiles(new Path($pathToFile));
    }

    public function test_with_empty_directory(): void
    {
        $testsRoot = dirname(__DIR__, 3);

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory is empty [$testsRoot/Fixtures/Mappings/EmptyDirectory]");

        $locator = new MappingLocator();

        self::assertEmpty(
            $locator->findMappingFiles(new Path($testsRoot . '/Fixtures/Mappings/EmptyDirectory'))
        );
    }
}
