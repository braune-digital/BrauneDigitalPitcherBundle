<?php

namespace BrauneDigital\PitcherBundle\Filter;

use BrauneDigital\Pitcher\Notification\Notification;
use BrauneDigital\Pitcher\Notification\NotificationInterface;
use BrauneDigital\PitcherBundle\Notification\ExceptionNotification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpLevelFilter implements FilterInterface
{
    protected $levelMapping = [
        300 => Notification::LEVEL_INFO,
        400 => Notification::LEVEL_ERROR,
        500 => Notification::LEVEL_CRITICAL
    ];


    public function process(NotificationInterface $notification) {
        if ($notification instanceof ExceptionNotification) {

            $exception = $notification->getException();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();

                $level = null;

                // Find corresponding message
                foreach ($this->levelMapping as $minStatus => $l) {
                    if ($statusCode >= $minStatus) {
                        $level = $l;
                    }
                }
                if ($level === null) {
                    // Filter message
                    return null;
                }

                $notification->setLevel($level);
            }

        }

        return $notification;
    }
}