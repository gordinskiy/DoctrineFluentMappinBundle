<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLoader;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use LaravelDoctrine\Fluent\FluentDriver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class DoctrineFluentMappingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $mappers = [];

        if (!empty($config['mappers']['list'])) {
            $mappers = $config['mappers']['list'];
        }

        if (!empty($config['mappers']['auto_locator']['directories'])) {
            $rootDir = (string) $container->getParameter('kernel.project_dir');

            $directories = [];

            foreach ($config['mappers']['auto_locator']['directories'] as $dirPath) {
                if (!str_starts_with($dirPath, $rootDir)) {
                    if (!str_starts_with($dirPath, DIRECTORY_SEPARATOR)) {
                        $dirPath = DIRECTORY_SEPARATOR . $dirPath;
                    }

                    $dirPath = $rootDir . $dirPath;
                }

                $directories[] = $dirPath;
            }

            $loader = new MappingLoader(
                new MappingLocator(...$directories)
            );

            $mappers = array_merge($mappers, $loader->getAllEntityMappers());
        }

        if (!empty($mappers)) {
            $container->setDefinition(
                FluentDriver::class,
                (new Definition(FluentDriver::class))
                    ->addArgument(
                        $mappers
                    )
            );
        }
    }

    public function getAlias(): string
    {
        return 'doctrine_fluent';
    }
}
