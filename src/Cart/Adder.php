<?php
namespace Ecommerce\Cart;

use Ecommerce\Db\Cart\Entity;
use Ecommerce\Db\Cart\Saver;
use Exception;
use Log\Log;

class Adder
{
	private Creator $creator;

	private Saver $entitySaver;

	public function __construct(Creator $creator, Saver $entitySaver)
	{
		$this->creator     = $creator;
		$this->entitySaver = $entitySaver;
	}

	public function add(): ?Cart
	{
		try
		{
			$entity = new Entity();

			$this->entitySaver->save($entity);

			return $this->creator->byEntity($entity);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return null;
	}
}