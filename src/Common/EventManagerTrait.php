<?php
namespace Ecommerce\Common;

use Laminas\EventManager\EventManagerInterface;

trait EventManagerTrait
{
	/**
	 * @var EventManagerInterface
	 */
	private $eventManager;

	/**
	 * @param EventManagerInterface $eventManager
	 */
	public function setEventManager(EventManagerInterface $eventManager)
	{
		$eventManager->setIdentifiers([ Event::ID ]);

		$this->eventManager = $eventManager;
	}

	/**
	 * @return EventManagerInterface
	 */
	public function getEventManager()
	{
		return $this->eventManager;
	}
}