<?php

namespace BrauneDigital\PitcherBundle\Handler;

use BrauneDigital\Pitcher\Notification\NotificationInterface;

class OnTerminateHandler implements HandlerInterface
{
    /** @var HandlerInterface */
    protected $mainHandler;

    protected $cachedNotifications = [];

    public function __construct(HandlerInterface $handler) {
        $this->mainHandler = $handler;
    }

    public function handleNotification(NotificationInterface $notification) {
        $this->cachedNotifications[] = $notification;
    }

    public function onKernelTerminate() {
        foreach ($this->cachedNotifications as $notification) {
            $this->mainHandler->handleNotification($notification);
        }
    }
}