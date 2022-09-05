<?php
namespace Ecommerce\Common;

use Laminas\EventManager\EventManagerInterface;

trait EventManagerTrait
{
	private ?EventManagerInterface $eventManager = null;

	public function setEventManager(EventManagerInterface $eventManager)
	{
		$eventManager->setIdentifiers([ Event::ID ]);

		$this->eventManager = $eventManager;
	}

	public function getEventManager(): ?EventManagerInterface
	{
		return $this->eventManager;
	}
}