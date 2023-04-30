<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use LaravelDoctrine\Fluent\FluentDriver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MappingDriverCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->setDefinition(
            'doctrine.orm.default_metadata_driver',
            $container->getDefinition(FluentDriver::class)
        );
    }
}
