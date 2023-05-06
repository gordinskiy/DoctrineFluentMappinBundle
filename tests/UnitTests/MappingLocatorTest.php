<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests;

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
        self::markTestSkipped('TODO: Fix this test');
        $locator = new MappingLocator('../Fixtures/Mappers/NestedDirectoriesWithMappers');

        self::assertSame(
            expected: $locator->getAllMappers(),
            actual: [
                '../Fixtures/Mappers/NestedDirectoriesWithMappers/UserMapper.php',
            ]
        );
    }

    public function test_without_paths(): void
    {
        $locator = new MappingLocator();

        self::assertEmpty($locator->getAllMappers());
    }

    // TODO: Exception must be thrown
    public function test_with_wrong_path(): void
    {
        $locator = new MappingLocator('wrong_path');

        self::assertEmpty($locator->getAllMappers());
    }

    // TODO: Exception must be thrown
    public function test_with_empty_directory(): void
    {
        $locator = new MappingLocator('../Fixtures/Mappers/EmptyDirectory');

        self::assertEmpty($locator->getAllMappers());
    }
}
