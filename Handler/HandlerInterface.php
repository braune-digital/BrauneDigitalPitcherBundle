<?php

namespace BrauneDigital\PitcherBundle\Handler;

use BrauneDigital\Pitcher\Notification\NotificationInterface;

interface HandlerInterface
{
    public function handleNotification(NotificationInterface $notification);
}