<?php

namespace BrauneDigital\PitcherBundle\Filter;

class FilterManager
{
    /** @var  ChainFilter */
   protected $chainFilter;

    /**
     * FilterManager constructor.
     * @param ChainFilter $chainFilter
     */
    public function __construct() {
        $this->chainFilter = new ChainFilter();
    }

    public function addFilter(FilterInterface $filter) {
        $this->chainFilter->append($filter);
    }

    public function getChainFilter() {
        return $this->chainFilter;
    }

    // Add Basic filters
    public static function createBaseFilter($config) {
        $baseFilter = new ChainFilter();

        if (isset($config['threshold'])) {
            $baseFilter->append(new HttpThresholdFilter($config['threshold']));
        }

        if (isset($config['ignore_exceptions'])) {
            foreach ($config['ignore_exceptions'] as $exceptionClass) {
                $baseFilter->append(new ExceptionFilter($exceptionClass));
            }
        }

        $baseFilter->append(new HttpLevelFilter());
        return $baseFilter;
    }
}