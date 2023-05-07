<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests;

use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLoader;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\{
    DirectoryWithSeveralMappers\OrderMapper,
    DirectoryWithSeveralMappers\ProductMapper,
    DirectoryWithSeveralMappers\UserMapper,
};
use PHPUnit\Framework\TestCase;

class MappingLoaderTest extends TestCase
{
    public function test_entity_mapping_loading(): void
    {
        $rootDir = dirname(__DIR__, 1);
        $locator = new MappingLocator($rootDir . '/Fixtures/Mappers/DirectoryWithSeveralMappers');
        $loader = new MappingLoader($locator);

        $this->assertSame(
            expected: $loader->getAllEntityMappers(),
            actual: [
                OrderMapper::class,
                ProductMapper::class,
                UserMapper::class,
            ]
        );
    }
}
