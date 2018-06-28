<?php

namespace BrauneDigital\PitcherBundle\Handler;

use BrauneDigital\Pitcher\Notification\NotificationInterface;
use BrauneDigital\PitcherBundle\Client\Client;

/**
 * Class DirectHandler
 * @package BrauneDigital\PitcherBundle\Handler
 * Diretly send messages via the client
 */
class DirectHandler implements HandlerInterface
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function handleNotification(NotificationInterface $notification) {
        // Just pitch notification
        $this->client->pitch(
            $notification->getLevel(),
            $notification->getMessage()
        );
    }
}