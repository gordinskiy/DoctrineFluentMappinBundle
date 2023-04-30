<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('doctrine_php_mapper');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('mappers')
                    ->children()
                        ->arrayNode('list')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
