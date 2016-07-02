<?php

namespace BrauneDigital\PitcherBundle\EventSubscriber;

use BrauneDigital\Pitcher\Notification\Notification;
use BrauneDigital\PitcherBundle\Client\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionSubscriber implements EventSubscriberInterface
{

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param Client $client
	 */
	public function setClient(Client $client) {
		$this->client = $client;
	}

	public function setContainer(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public static function getSubscribedEvents()
	{
		return array(
			KernelEvents::EXCEPTION => array(
				array('logException', 0),
			)
		);
	}

	public function logException(GetResponseForExceptionEvent $event)
	{
		$exception = $event->getException();
		$config = $this->container->getParameter('braune_digital_pitcher');
		if (
			!$exception instanceof HttpExceptionInterface &&
			!$exception instanceof AuthenticationException
		) {
			$this->client->pitch(Notification::LEVEL_CRITICAL, $this->getMessage($exception));
		} else if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() >= $config['threshold']) {
			if ($exception->getStatusCode() >= 300 && $exception->getStatusCode() < 400) {
				$this->client->pitch(Notification::LEVEL_INFO, $this->getMessage($exception));
			} else if ($exception->getStatusCode() >= 400 && $exception->getStatusCode() < 500) {
				$this->client->pitch(Notification::LEVEL_ERROR, $this->getMessage($exception));
			} else if ($exception->getStatusCode() >= 500) {
				$this->client->pitch(Notification::LEVEL_CRITICAL, $this->getMessage($exception));
			}
		}
	}

	private function getMessage(\Exception $exception) {
		return 'Pitcher exception subscriber (' . $exception->getFile() . '[' . $exception->getLine() . ']:' . $exception->getMessage() . ')';
	}

}