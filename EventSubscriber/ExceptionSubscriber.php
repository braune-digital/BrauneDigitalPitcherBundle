<?php

namespace BrauneDigital\PitcherBundle\EventSubscriber;

use BrauneDigital\Pitcher\Notification\Notification;
use BrauneDigital\PitcherBundle\Client\Client;
use BrauneDigital\PitcherBundle\Handler\HandlerInterface;
use BrauneDigital\PitcherBundle\Notification\ExceptionNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
	/**
	 * @var HandlerInterface
	 */
	protected $handler;

	/**
	 * @param Client $client
	 */
	public function setHandler(HandlerInterface $handler) {
		$this->handler = $handler;
	}

	public static function getSubscribedEvents()
	{
		return array(
			KernelEvents::EXCEPTION => array(
				array('handleException', 0),
			)
		);
	}

    public function handleException(GetResponseForExceptionEvent $event) {
        $exception = $event->getException();
        $message = (new \ReflectionClass($exception))->getShortName() . ' in ' . $exception->getFile() . '[' . $exception->getLine() . ']:' . $exception->getMessage();

        //Per default handle all notifications as critical
        $notification = new ExceptionNotification($exception, Notification::LEVEL_CRITICAL, $message, null);
        $this->handler->handleNotification($notification);
    }
}