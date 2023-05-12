<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLoader;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use Gordinskiy\Fixtures\Mappers\DirectoryWithSeveralMappers\OrderMapper;
use Gordinskiy\Fixtures\Mappers\DirectoryWithSeveralMappers\ProductMapper;
use Gordinskiy\Fixtures\Mappers\DirectoryWithSeveralMappers\UserMapper;
use Gordinskiy\Fixtures\Mappers\NestedDirectoriesWithMappers\UserMapper as AnotherUserMapper;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class MappingLoaderTest extends TestCase
{
    public function test_entity_mapping_loading(): void
    {
        $rootDir = dirname(__DIR__, 2);
        $locator = new MappingLocator($rootDir . '/Fixtures/Mappers/DirectoryWithSeveralMappers');
        $loader = new MappingLoader($locator);

        $this->assertSame(
            expected: $loader->getAllEntityMappers(),
            actual: [
                OrderMapper::class,
                UserMapper::class,
                ProductMapper::class,
            ]
        );
    }

    /**
     * @description Depends on previous test to ensure that another UserMapper class was loaded
     */
    #[Depends('test_entity_mapping_loading')]
    public function test_entity_mapping_loading_with_duplicated_mapping(): void
    {
        $rootDir = dirname(__DIR__, 2);

        $locator = new MappingLocator($rootDir . '/Fixtures/Mappers/NestedDirectoriesWithMappers');
        $loader = new MappingLoader($locator);

        $this->assertSame(
            expected: $loader->getAllEntityMappers(),
            actual: [
                AnotherUserMapper::class,
            ]
        );
    }
}
