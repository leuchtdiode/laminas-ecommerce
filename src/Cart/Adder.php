<?php
namespace Ecommerce\Cart;

use Ecommerce\Db\Cart\Entity;
use Ecommerce\Db\Cart\Saver;
use Exception;
use Log\Log;

class Adder
{
	/**
	 * @var Creator
	 */
	private $creator;

	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @param Creator $creator
	 * @param Saver $entitySaver
	 */
	public function __construct(Creator $creator, Saver $entitySaver)
	{
		$this->creator     = $creator;
		$this->entitySaver = $entitySaver;
	}

	/**
	 * @return Cart|null
	 */
	public function add()
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