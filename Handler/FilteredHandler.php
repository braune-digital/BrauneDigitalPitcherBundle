<?php

namespace BrauneDigital\PitcherBundle\Handler;

use BrauneDigital\Pitcher\Notification\NotificationInterface;
use BrauneDigital\PitcherBundle\Filter\FilterInterface;

class FilteredHandler implements HandlerInterface
{
    /** @var  HandlerInterface */
    protected $handler;

    /** @var  FilterInterface */
    protected $filter;


    public function __construct(HandlerInterface $handler, FilterInterface $filter) {
        $this->handler = $handler;
        $this->filter = $filter;
    }

    public function handleNotification(NotificationInterface $notification) {
        if ($this->filter !== null) {
            $notification = $this->filter->process($notification);
            if ($notification !== null) {
                $this->handler->handleNotification($notification);
            }
        }
    }
}