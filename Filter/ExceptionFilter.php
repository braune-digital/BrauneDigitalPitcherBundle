<?php

namespace BrauneDigital\PitcherBundle\Filter;

use BrauneDigital\Pitcher\Notification\NotificationInterface;
use BrauneDigital\PitcherBundle\Notification\ExceptionNotification;

class ExceptionFilter implements FilterInterface
{
    /** @var  string */
    protected $exceptionClass;

    public function __construct($exceptionClass) {
        $this->exceptionClass = $exceptionClass;
    }

    public function process(NotificationInterface $notification) {
        if ($notification instanceof ExceptionNotification) {

            $exception = $notification->getException();
            // filter exceptions, including extensions
            if ($this->exceptionClass !== null && (get_class($exception) === $this->exceptionClass || is_subclass_of($exception, $this->exceptionClass))) {
                return null;
            }
        }

        return $notification;
    }
}