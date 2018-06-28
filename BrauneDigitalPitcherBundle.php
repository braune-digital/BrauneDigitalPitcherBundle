<?php

namespace BrauneDigital\PitcherBundle;

use BrauneDigital\PitcherBundle\DependencyInjection\Compiler\FilterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BrauneDigitalPitcherBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new FilterCompilerPass());
    }
}