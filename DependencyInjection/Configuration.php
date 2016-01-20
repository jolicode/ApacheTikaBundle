<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace Joli\ApacheTikaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('apache_tika');

        $rootNode
            ->children()
                ->arrayNode('config')
                    ->children()
                        ->scalarNode('tika_path')->end()
                        ->scalarNode('tika_host')->end()
                        ->scalarNode('tika_port')->end()
                    ->end()
                ->end() // tika_config
            ->end()
        ;

        return $treeBuilder;
    }
}
