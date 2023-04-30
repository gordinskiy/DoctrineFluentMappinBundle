<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use LaravelDoctrine\Fluent\FluentDriver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class DoctrineFluentMappingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        if (!empty($config['mappers']['list'])) {
            $container->setDefinition(
                FluentDriver::class,
                (new Definition(FluentDriver::class))
                    ->addArgument(
                        $config['mappers']['list']
                    )
            );
        }
    }

    public function getAlias(): string
    {
        return 'doctrine_fluent';
    }
}
