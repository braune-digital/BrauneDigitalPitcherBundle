<?php

namespace BrauneDigital\PitcherBundle\Notification;

use BrauneDigital\Pitcher\Notification\Notification;

class ExceptionNotification extends Notification
{
    /** @var \Exception  */
    protected $exception;

    /**
     * ExceptionNotification constructor.
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception, $level, $message, $satellite) {
        $this->exception = $exception;
        parent::__construct($level, $message, $satellite);
    }

    /**
     * @return \Exception
     */
    public function getException() {
        return $this->exception;
    }
}