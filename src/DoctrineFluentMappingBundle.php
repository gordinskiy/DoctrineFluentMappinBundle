<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle;

use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\DoctrineFluentMappingExtension;
use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\MappingDriverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DoctrineFluentMappingBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new MappingDriverCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DoctrineFluentMappingExtension();
    }
}
