<?php
namespace Ecommerce\Transaction;

use Ecommerce\Db\Transaction\Saver as EntitySaver;
use Exception;
use Log\Log;

class Saver
{
	/**
	 * @var EntitySaver
	 */
	private $entitySaver;

	/**
	 * @param EntitySaver $entitySaver
	 */
	public function __construct(EntitySaver $entitySaver)
	{
		$this->entitySaver = $entitySaver;
	}

	/**
	 * @param SaveData $data
	 * @return SaveResult
	 */
	public function save(SaveData $data)
	{
		$result = new SaveResult();
		$result->setSuccess(false);

		try
		{
			$entity = $data
				->getTransaction()
				->getEntity();

			$entity->setStatus($data->getStatus());

			$this->entitySaver->save($entity);

			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}