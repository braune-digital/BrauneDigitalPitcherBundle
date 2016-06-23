<?php

namespace BrauneDigital\PitcherBundle\EventSubscriber;

use BrauneDigital\Pitcher\Notification\Notification;
use BrauneDigital\PitcherBundle\Client\Client;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @param Client $client
	 */
	public function setClient(Client $client) {
		$this->client = $client;
	}

	public static function getSubscribedEvents()
	{
		return array(
			KernelEvents::EXCEPTION => array(
				array('processException', 10),
				array('logException', 0),
				array('notifyException', -10)
			)
		);
	}

	public function processException(GetResponseForExceptionEvent $event)
	{
		$this->client->pitch(Notification::LEVEL_CRITICAL, 'Pitcher exception subscriber (' . $event->getException()->getFile() . '[' . $event->getException()->getLine() . ']:' . $event->getException()->getMessage() . ')');
	}

	public function logException(GetResponseForExceptionEvent $event)
	{

	}

	public function notifyException(GetResponseForExceptionEvent $event)
	{

	}

}