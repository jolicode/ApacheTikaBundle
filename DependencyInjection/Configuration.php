<?php

namespace welcoMattic\ApacheTikaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('apache_tika');

        $rootNode
            ->children()
                ->arrayNode('tika_config')
                    ->children()
                        ->scalarNode('tika_path')->end()
                        ->scalarNode('tika_host')->isRequired()->defaultValue('127.0.0.1')->end()
                        ->scalarNode('tika_port')->isRequired()->defaultValue('9998')->end()
                    ->end()
                ->end() // tika_config
            ->end()
        ;
        return $treeBuilder;
    }
}
