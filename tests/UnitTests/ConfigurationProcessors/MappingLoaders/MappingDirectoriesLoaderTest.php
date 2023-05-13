<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders\MappingDirectoriesLoader;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLocators\MappingLocator;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\ProductMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\UserMapping;
use Gordinskiy\Fixtures\Mappings\NestedDirectoriesWithMappings\UserMapping as AnotherUserMappings;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class MappingDirectoriesLoaderTest extends TestCase
{
    // TODO: Remove Locator from loader test
    public function test_entity_mapping_loading(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $locator = new MappingLocator();
        $loader = new MappingDirectoriesLoader();

        $this->assertSame(
            expected: $loader->loadMappings(
                ...$locator->findMappingFiles($rootDir . '/Fixtures/Mappings/DirectoryWithSeveralMappings')
            ),
            actual: [
                OrderMapping::class,
                ProductMapping::class,
                UserMapping::class,
            ]
        );
    }

    /**
     * @description Depends on previous test to ensure that another UserMappings class was loaded
     */
    #[Depends('test_entity_mapping_loading')]
    public function test_entity_mapping_loading_with_duplicated_mapping(): void
    {
        $rootDir = dirname(__DIR__, 3);

        $locator = new MappingLocator();
        $loader = new MappingDirectoriesLoader();

        $this->assertSame(
            expected: $loader->loadMappings(
                ...$locator->findMappingFiles($rootDir . '/Fixtures/Mappings/NestedDirectoriesWithMappings')
            ),
            actual: [
                AnotherUserMappings::class,
            ]
        );
    }
}
