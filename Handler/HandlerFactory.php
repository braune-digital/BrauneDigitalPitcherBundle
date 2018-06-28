<?php

namespace BrauneDigital\PitcherBundle\Handler;
use BrauneDigital\PitcherBundle\Filter\FilterManager;

class HandlerFactory
{
    public static function createHandler(HandlerInterface $baseHandler, FilterManager $filterManager ) {
        return new FilteredHandler($baseHandler, $filterManager->getChainFilter());
    }
}