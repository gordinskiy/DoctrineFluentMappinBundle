<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use PHPUnit\Framework\TestCase;

class MappingLocatorTest extends TestCase
{
    public function test_directory_with_mappers(): void
    {
        $projectRoot = dirname(__DIR__, 1);
        $locator = new MappingLocator($projectRoot . '/Fixtures/Mappers/DirectoryWithSeveralMappers');

        self::assertSame(
            expected: $locator->getAllMappers(),
            actual: [
                $projectRoot . '/Fixtures/Mappers/DirectoryWithSeveralMappers/OrderMapper.php',
                $projectRoot . '/Fixtures/Mappers/DirectoryWithSeveralMappers/ProductMapper.php',
                $projectRoot . '/Fixtures/Mappers/DirectoryWithSeveralMappers/UserMapper.php',
            ]
        );
    }

    public function test_nested_directory_with_mappers(): void
    {
        $testsRoot = dirname(__DIR__, 1);
        $locator = new MappingLocator($testsRoot . '/Fixtures/Mappers/NestedDirectoriesWithMappers');

        self::assertSame(
            expected: $locator->getAllMappers(),
            actual: [
                $testsRoot . '/Fixtures/Mappers/NestedDirectoriesWithMappers/UserMapper.php',
            ]
        );
    }

    public function test_without_paths(): void
    {
        $locator = new MappingLocator();

        self::assertEmpty($locator->getAllMappers());
    }

    public function test_with_wrong_path(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory does not exist [wrong_path]");

        $locator = new MappingLocator('wrong_path');

        $locator->getAllMappers();
    }

    public function test_with_empty_directory(): void
    {
        $testsRoot = dirname(__DIR__, 1);

        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping directory is empty [$testsRoot/Fixtures/Mappers/EmptyDirectory]");


        $locator = new MappingLocator($testsRoot . '/Fixtures/Mappers/EmptyDirectory');

        self::assertEmpty($locator->getAllMappers());
    }
}
