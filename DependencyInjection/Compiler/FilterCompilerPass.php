<?php
namespace BrauneDigital\PitcherBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterCompilerPass implements CompilerPassInterface {

    /**
     * Collect all filter tagged services and load them into the query manager
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('pitcher.filter_manager')) {
            return;
        }

        $definition = $container->findDefinition(
            'pitcher.filter_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'pitcher.filter'
        );


        $filters = [];
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $filters[] = [
                    'order' => isset($attributes['order']) ? $attributes['order'] :  0,
                    'id' => $id
                ];
            }
        }

        usort($filters, function($a, $b) {
            return $a['order'] <= $b['order'] ? -1 : 1;
        });

        foreach ($filters as $filter) {
            $definition->addMethodCall(
                'addFilter',
                array(new Reference($filter['id']))
            );
        };
    }
}