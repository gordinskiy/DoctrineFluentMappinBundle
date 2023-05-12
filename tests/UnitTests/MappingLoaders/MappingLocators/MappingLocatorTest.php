<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\MappingLoaders\MappingLocators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use PHPUnit\Framework\TestCase;

class MappingLocatorTest extends TestCase
{
    public function test_directory_with_mappings(): void
    {
        $projectRoot = dirname(__DIR__, 3);
        $locator = new MappingLocator($projectRoot . '/Fixtures/Mappings/DirectoryWithSeveralMappings');

        self::assertSame(
            expected: $locator->getAllMappings(),
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
        $locator = new MappingLocator($testsRoot . '/Fixtures/Mappings/NestedDirectoriesWithMappings');

        self::assertSame(
            expected: $locator->getAllMappings(),
            actual: [
                $testsRoot . '/Fixtures/Mappings/NestedDirectoriesWithMappings/UserMapping.php',
            ]
        );
    }

    public function test_without_paths(): void
    {
        $locator = new MappingLocator();

        self::assertEmpty($locator->getAllMappings());
    }

    public function test_with_wrong_path(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory does not exist [wrong_path]");

        $locator = new MappingLocator('wrong_path');

        $locator->getAllMappings();
    }

    public function test_with_empty_directory(): void
    {
        $testsRoot = dirname(__DIR__, 3);

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory is empty [$testsRoot/Fixtures/Mappings/EmptyDirectory]");

        $locator = new MappingLocator($testsRoot . '/Fixtures/Mappings/EmptyDirectory');

        self::assertEmpty($locator->getAllMappings());
    }
}
