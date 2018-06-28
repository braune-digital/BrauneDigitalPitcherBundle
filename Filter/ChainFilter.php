<?php

namespace BrauneDigital\PitcherBundle\Filter;

use BrauneDigital\Pitcher\Notification\NotificationInterface;

class ChainFilter implements FilterInterface
{
    /** @var FilterInterface[]  */
    protected $filters = [];

    /**
     * HttpThresholdFilter constructor.
     */
    public function __construct($filters = array()) {
        $this->filters = $filters;
    }

    public function append(FilterInterface $filter) {
        $this->filters[] = $filter;
        return $this;
    }

    public function prepend(FilterInterface $filter) {
        array_unshift($this->filters, $filter);
        return $this;
    }

    public function process(NotificationInterface $notification) {
        foreach ($this->filters as $filter) {
            $notification = $filter->process($notification);
            // check that the message has not been filtered
            if ($notification === null) {
                break;
            }
        }
        return $notification;
    }
}