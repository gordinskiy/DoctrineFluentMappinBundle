<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const MAPPINGS_KEY = 'mappings';
    public const MAPPINGS_PATHS_KEY = 'mapping_paths';

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('doctrine_fluent');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode(self::MAPPINGS_KEY)
                    ->cannotBeEmpty()
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
                ->arrayNode(self::MAPPINGS_PATHS_KEY)
                    ->cannotBeEmpty()
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
