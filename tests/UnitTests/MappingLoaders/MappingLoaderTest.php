<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLoader;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\ProductMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\UserMapping;
use Gordinskiy\Fixtures\Mappings\NestedDirectoriesWithMappings\UserMapping as AnotherUserMappings;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class MappingLoaderTest extends TestCase
{
    public function test_entity_mapping_loading(): void
    {
        $rootDir = dirname(__DIR__, 2);
        $locator = new MappingLocator($rootDir . '/Fixtures/Mappings/DirectoryWithSeveralMappings');
        $loader = new MappingLoader($locator);

        $this->assertSame(
            expected: $loader->getAllEntityMappings(),
            actual: [
                OrderMapping::class,
                UserMapping::class,
                ProductMapping::class,
            ]
        );
    }

    /**
     * @description Depends on previous test to ensure that another UserMappings class was loaded
     */
    #[Depends('test_entity_mapping_loading')]
    public function test_entity_mapping_loading_with_duplicated_mapping(): void
    {
        $rootDir = dirname(__DIR__, 2);

        $locator = new MappingLocator($rootDir . '/Fixtures/Mappings/NestedDirectoriesWithMappings');
        $loader = new MappingLoader($locator);

        $this->assertSame(
            expected: $loader->getAllEntityMappings(),
            actual: [
                AnotherUserMappings::class,
            ]
        );
    }
}
