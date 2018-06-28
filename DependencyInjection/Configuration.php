<?php

namespace BrauneDigital\PitcherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

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
                ->scalarNode('threshold')->defaultValue(500)->end()
            ->end()
        ;


        $handlerMapping = [
            'direct' => 'pitcher.handler.direct',
            'on_terminate' => 'pitcher.handler.on_terminate',
            'terminate' => 'pitcher.handler.on_terminate'
        ];
        $rootNode->children()->scalarNode('handler')->defaultValue('pitcher.handler.direct')
            ->beforeNormalization()
            ->ifInArray(array_keys($handlerMapping))
            ->then(function ($v) use ($handlerMapping) {return $handlerMapping[$v];});

        $this->addFiltersNode($rootNode);
        return $treeBuilder;
    }


    public function addFiltersNode(ArrayNodeDefinition $rootNode) {

        $rootNode->
                children()
                    ->arrayNode('ignore_exceptions')->prototype('scalar')->end()->defaultValue([
            AuthenticationException::class,
            NotFoundHttpException::class
        ]);
    }
}
