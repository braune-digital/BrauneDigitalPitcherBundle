<?php

namespace BrauneDigital\PitcherBundle\Filter;

use BrauneDigital\Pitcher\Notification\NotificationInterface;

interface FilterInterface
{
    /**
     * @param NotificationInterface $notification
     * @return NotificationInterface|null
     */
    public function process(NotificationInterface $notification);
}