<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders\MappingDirectoriesLoader;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\ProductMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\UserMapping;
use Gordinskiy\Fixtures\Mappings\NestedDirectoriesWithMappings\UserMapping as AnotherUserMappings;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class MappingDirectoriesLoaderTest extends TestCase
{
    public function test_entity_mapping_loading(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $loader = new MappingDirectoriesLoader();

        $this->assertSame(
            expected: [
                OrderMapping::class,
                ProductMapping::class,
                UserMapping::class,
            ],
            actual: $loader->loadMappings(
                $rootDir . "/Fixtures/Mappings/DirectoryWithSeveralMappings/OrderMapping.php",
                $rootDir . "/Fixtures/Mappings/DirectoryWithSeveralMappings/ProductMapping.php",
                $rootDir . "/Fixtures/Mappings/DirectoryWithSeveralMappings/UserMapping.php",
            )
        );
    }

    /**
     * @description Depends on previous test to ensure that another UserMappings class was loaded
     */
    #[Depends('test_entity_mapping_loading')]
    public function test_entity_mapping_loading_with_duplicated_mapping(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $loader = new MappingDirectoriesLoader();

        $this->assertSame(
            expected: [
                AnotherUserMappings::class,
            ],
            actual: $loader->loadMappings(
                $rootDir . "/Fixtures/Mappings/NestedDirectoriesWithMappings/UserMapping.php"
            )
        );
    }
}
