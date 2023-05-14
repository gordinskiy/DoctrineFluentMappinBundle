<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors\MappingLoaders;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingLoaders\MappingDirectoriesLoader;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\DirectoryPath;
use Gordinskiy\DoctrineFluentMappingBundle\ValueObjects\FilePath;
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

        $directory = new DirectoryPath($rootDir . "/Fixtures/Mappings/DirectoryWithSeveralMappings");

        $this->assertSame(
            expected: [
                OrderMapping::class,
                ProductMapping::class,
                UserMapping::class,
            ],
            actual: $loader->loadMappings(
                new FilePath("OrderMapping.php", $directory),
                new FilePath("ProductMapping.php", $directory),
                new FilePath("UserMapping.php", $directory),
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

        $directory = new DirectoryPath($rootDir . "/Fixtures/Mappings/NestedDirectoriesWithMappings");

        $this->assertSame(
            expected: [
                AnotherUserMappings::class,
            ],
            actual: $loader->loadMappings(
                new FilePath("UserMapping.php", $directory),
            )
        );
    }
}
