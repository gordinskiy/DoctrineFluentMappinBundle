<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocator;
use PHPUnit\Framework\TestCase;

class MappingLocatorTest extends TestCase
{
    public function test_directory_with_mappings(): void
    {
        $projectRoot = dirname(__DIR__, 3);
        $locator = new MappingLocator();

        self::assertSame(
            expected: $locator->findMappingFiles($projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings'),
            actual: [
                $projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings/OrderMapping.php',
                $projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings/ProductMapping.php',
                $projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings/UserMapping.php',
            ]
        );
    }

    public function test_nested_directory_with_mappings(): void
    {
        $testsRoot = dirname(__DIR__, 3);
        $locator = new MappingLocator();

        self::assertSame(
            expected: $locator->findMappingFiles($testsRoot . '/Fixtures/Mappings/NestedDirectoriesWithMappings'),
            actual: [
                $testsRoot . '/Fixtures/Mappings/NestedDirectoriesWithMappings/UserMapping.php',
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

        $locator->findMappingFiles('wrong_path');
    }

    public function test_with_file_path(): void
    {
        $testsRoot = dirname(__DIR__, 3);
        $pathToFile = $testsRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings/UserMapping.php';

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping path must be a directory [$pathToFile]");

        $locator = new MappingLocator();
        $locator->findMappingFiles($pathToFile);
    }

    public function test_with_empty_directory(): void
    {
        $testsRoot = dirname(__DIR__, 3);

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory is empty [$testsRoot/Fixtures/Mappings/EmptyDirectory]");

        $locator = new MappingLocator();

        self::assertEmpty($locator->findMappingFiles($testsRoot . '/Fixtures/Mappings/EmptyDirectory'));
    }
}
