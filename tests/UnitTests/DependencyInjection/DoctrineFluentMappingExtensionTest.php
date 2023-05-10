<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\DoctrineFluentMappingExtension;
use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\DirectoryWithSeveralMappers\OrderMapper;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\DirectoryWithSeveralMappers\ProductMapper;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\DirectoryWithSeveralMappers\UserMapper;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\NestedDirectoriesWithMappers\UserMapper as AnotherUser;
use LaravelDoctrine\Fluent\FluentDriver;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Yaml\Yaml;

class DoctrineFluentMappingExtensionTest extends TestCase
{
    protected readonly ContainerBuilder&MockObject $containerBuilderMock;
    protected function setUp(): void
    {
        $this->containerBuilderMock = $this->createMock(ContainerBuilder::class);
        parent::setUp();
    }

    public function test_alias(): void
    {
        $extension = new DoctrineFluentMappingExtension();

        self::assertEquals(
            expected: 'doctrine_fluent',
            actual: $extension->getAlias()
        );
    }

    public function test_load_with_empty_configuration(): void
    {
        $extension = new DoctrineFluentMappingExtension();

        $config = self::processYamlConfig('empty_root.yaml');


        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage('No mappings or mappings paths provided');
        $extension->load($config, $this->containerBuilderMock);
    }

    public function test_load_with_configured_mappings(): void
    {
        $extension = new DoctrineFluentMappingExtension();

        $config = self::processYamlConfig('valid_mappings.yaml');

        $this->containerBuilderMock->expects($this->once())
            ->method('setDefinition')->with(
                $this->equalTo(FluentDriver::class),
                $this->equalTo((new Definition(FluentDriver::class))
                    ->addArgument(
                        $config['doctrine_fluent']['mappings']
                    ))
            );

        $extension->load($config, $this->containerBuilderMock);
    }

    public function test_load_with_configured_mappings_paths(): void
    {
        $extension = new DoctrineFluentMappingExtension();
        $config = self::processYamlConfig('valid_mappings_paths.yaml');
        $rootDir = dirname(__DIR__, 3);

        $this->containerBuilderMock->expects($this->once())
            ->method('getParameter')
            ->with('kernel.project_dir')
            ->willReturn($rootDir);

        $this->containerBuilderMock->expects($this->once())
            ->method('setDefinition')->with(
                $this->equalTo(FluentDriver::class),
                $this->equalTo((new Definition(FluentDriver::class))
                    ->addArgument(
                        [
                            OrderMapper::class,
                            ProductMapper::class,
                            UserMapper::class,
                            AnotherUser::class,
                        ]
                    ))
            );

        $extension->load($config, $this->containerBuilderMock);
    }

    private static function processYamlConfig(string $configFile): array
    {
        $rootPath = dirname(__DIR__, 2);
        return Yaml::parse(
            file_get_contents("{$rootPath}/Fixtures/Configs/{$configFile}")
        );
    }
}
