<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingProcessor;
use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingsPathsProcessor;
use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
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

        $mappings = [];

        if (!empty($config[Configuration::MAPPINGS_KEY])) {
            $mappings = (new MappingProcessor(
                ...$config[Configuration::MAPPINGS_KEY]
            ))->getMappings();
        }

        if (!empty($config[Configuration::MAPPINGS_PATHS_KEY])) {
            $processor = new MappingsPathsProcessor(
                (string) $container->getParameter('kernel.project_dir')
            );

            $mappings = array_merge($mappings, $processor->process(...$config[Configuration::MAPPINGS_PATHS_KEY]));
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
