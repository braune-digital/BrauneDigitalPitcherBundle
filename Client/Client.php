<?php

namespace BrauneDigital\PitcherBundle\Client;

use BrauneDigital\Pitcher\Client\BaseClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Client extends BaseClient {

	/**
	 * @var
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$config = $this->container->getParameter('braune_digital_pitcher');
		parent::__construct($config['satellite_name'], $config['pitcher_url'], $config['secret'], $config['api_version']);
	}

	/**
	 * @param $level
	 * @param $message
	 * @param $satelliteName
	 */
	public function pitch($level, $message)
	{
		$config = $this->container->getParameter('braune_digital_pitcher');
		parent::pitch(
			$level,
			$message
		);
	}

}