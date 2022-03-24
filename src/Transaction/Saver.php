<?php
namespace Ecommerce\Transaction;

use Ecommerce\Db\Transaction\Saver as EntitySaver;
use Exception;
use Log\Log;

class Saver
{
	private EntitySaver $entitySaver;

	public function __construct(EntitySaver $entitySaver)
	{
		$this->entitySaver = $entitySaver;
	}

	public function save(SaveData $data): SaveResult
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