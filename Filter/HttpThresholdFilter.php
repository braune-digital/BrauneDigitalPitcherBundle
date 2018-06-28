<?php

namespace BrauneDigital\PitcherBundle\Filter;

use BrauneDigital\Pitcher\Notification\NotificationInterface;
use BrauneDigital\PitcherBundle\Notification\ExceptionNotification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpThresholdFilter implements FilterInterface
{
    /** @var int|null  */
    protected $threshold;

    /**
     * HttpThresholdFilter constructor.
     */
    public function __construct($threshold = null) {
        $this->threshold = $threshold;
    }

    public function process(NotificationInterface $notification) {

        if ($notification instanceof ExceptionNotification) {
            $exception = $notification->getException();
            if ($exception instanceof HttpException) {
                // Filter message by threshold
                if ($this->threshold !== null && $this->threshold > $exception->getStatusCode()) {
                    return null;
                }
            }

        }

        return $notification;
    }
}