<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Db\Cart\Item\Deleter;
use Exception;
use Log\Log;

class Remover
{
	/**
	 * @var Deleter
	 */
	private $entityDeleter;

	/**
	 * @param Deleter $entityDeleter
	 */
	public function __construct(Deleter $entityDeleter)
	{
		$this->entityDeleter = $entityDeleter;
	}

	public function remove(Item $item)
	{
		$result = new RemoveResult();
		$result->setSuccess(false);

		try
		{
			$this->entityDeleter->delete($item->getEntity());

			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}