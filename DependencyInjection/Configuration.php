<?php

namespace BrauneDigital\PitcherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('braune_digital_pitcher');
        $rootNode
            ->children()
                ->scalarNode('secret')->isRequired()->end()
                ->scalarNode('satellite_name')->isRequired()->end()
                ->scalarNode('pitcher_url')
                    ->defaultValue('https://api.pitcher-app.com/')
                ->end()
                ->scalarNode('api_version')
                    ->defaultValue('v1')
                ->end()
                ->scalarNode('threshold')->defaultValue('critical')->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
