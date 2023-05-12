<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\Configuration;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\ProductMapping;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\UserMapping;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class ConfigurationTest extends TestCase
{
    public function test_config_with_mappings(): void
    {
        $configuration = $this->processYamlConfig('valid_mappings.yaml');

        self::assertConfigurationStructure($configuration);
        self::assertEmpty($configuration['mappings_paths']);
        self::assertEquals(
            expected: [OrderMapping::class, UserMapping::class, ProductMapping::class],
            actual: $configuration['mappings']
        );
    }

    public function test_config_with_mappings_paths(): void
    {
        $configuration = $this->processYamlConfig('valid_mappings_paths.yaml');

        self::assertConfigurationStructure($configuration);
        self::assertEmpty($configuration['mappings']);
        self::assertEquals(
            expected: [
                'tests/Fixtures/Mappings/DirectoryWithSeveralMappings',
                'tests/Fixtures/Mappings/NestedDirectoriesWithMappings'
            ],
            actual: $configuration['mappings_paths'],
        );
    }

    public function test_combined_config(): void
    {
        $configuration = $this->processYamlConfig('valid_combined_mappings.yaml');

        self::assertConfigurationStructure($configuration);
        self::assertEquals(
            expected: [OrderMapping::class, UserMapping::class, ProductMapping::class],
            actual: $configuration['mappings']
        );
        self::assertEquals(
            expected: [
                'tests/Fixtures/Mappings/DirectoryWithSeveralMappings',
                'tests/Fixtures/Mappings/NestedDirectoriesWithMappings'
            ],
            actual: $configuration['mappings_paths'],
        );
    }

    public function test_config_with_invalid_key(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Unrecognized option "migrations" under "doctrine_fluent"');
        $this->processYamlConfig('invalid_key.yaml');
    }

    public function test_config_with_empty_mappings(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('The path "doctrine_fluent.mappings" should have at least 1 element(s) defined.');
        $this->processYamlConfig('empty_mappings.yaml');
    }

    public function test_config_with_invalid_mappings(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Invalid type for path "doctrine_fluent.mappings". Expected "array", but got "string"');
        $this->processYamlConfig('invalid_mappings.yaml');
    }

    public function test_config_with_empty_mappings_paths(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('The path "doctrine_fluent.mappings_paths" should have at least 1 element(s) defined.');
        $this->processYamlConfig('empty_mappings_paths.yaml');
    }

    public function test_config_with_invalid_mappings_paths(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Invalid type for path "doctrine_fluent.mappings_paths". Expected "array", but got "string"');
        $this->processYamlConfig('invalid_mappings_paths.yaml');
    }

    public function test_config_with_empty_root(): void
    {
        $this->markTestSkipped('Find out if it possible to require at least one of root children to be present');
        $this->processYamlConfig('empty_root.yaml');
    }

    private static function processYamlConfig(string $configFile): array
    {
        $rootPath = dirname(__DIR__, 2);
        $config = Yaml::parse(
            file_get_contents("{$rootPath}/Fixtures/Configs/{$configFile}")
        );

        return (new Processor())->processConfiguration(
            new Configuration(),
            [$config['doctrine_fluent']]
        );
    }

    private static function assertConfigurationStructure(array $configuration): void
    {
        self::assertArrayHasKey('mappings', $configuration);
        self::assertArrayHasKey('mappings_paths', $configuration);
    }
}
