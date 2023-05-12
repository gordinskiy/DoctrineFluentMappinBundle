<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLoader;
use Gordinskiy\DoctrineFluentMappingBundle\MappingLoaders\MappingLocators\MappingLocator;
use Gordinskiy\DoctrineFluentMappingBundle\Validators\MappingsValidator;
use LaravelDoctrine\Fluent\FluentDriver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class DoctrineFluentMappingExtension extends Extension
{
    /**
     * @inheritDoc
     *
     * @throws ConfigurationException
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $mappings = $config[Configuration::MAPPINGS_KEY];
        MappingsValidator::isValid(...$mappings);

        if (!empty($config[Configuration::MAPPINGS_PATHS_KEY])) {
            $rootDir = (string) $container->getParameter('kernel.project_dir');

            $directories = [];

            foreach ($config[Configuration::MAPPINGS_PATHS_KEY] as $dirPath) {
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

            $mappings = array_merge($mappings, $loader->getAllEntityMappers());
        }

        if (empty($mappings)) {
            throw ConfigurationException::mappingsNotConfigured();
        }

        $container->setDefinition(
            FluentDriver::class,
            (new Definition(FluentDriver::class))
                ->addArgument(
                    $mappings
                )
        );
    }

    public function getAlias(): string
    {
        return 'doctrine_fluent';
    }
}
