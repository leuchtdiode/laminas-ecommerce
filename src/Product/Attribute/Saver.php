<?php
namespace Ecommerce\Product\Attribute;

use Ecommerce\Db\Product\Attribute\Entity;
use Ecommerce\Db\Product\Attribute\Saver as EntitySaver;
use Exception;
use Log\Log;

class Saver
{
	private Provider $provider;

	private EntitySaver $entitySaver;

	public function __construct(Provider $provider, EntitySaver $entitySaver)
	{
		$this->provider    = $provider;
		$this->entitySaver = $entitySaver;
	}

	public function save(SaveData $data): SaveResult
	{
		$result = new SaveResult();
		$result->setSuccess(false);

		$attribute = $data->getAttribute();

		try
		{
			$entity = $attribute
				? $attribute->getEntity()
				: new Entity();

			$entity->setProcessableId(
				$data->getProcessableId()
			);
			$entity->setDescription(
				$data->getDescription()
			);
			$entity->setUnit(
				$data->getUnit()
			);

			$this->entitySaver->save($entity);

			$result->setAttribute(
				$this->provider->byId($entity->getId())
			);
			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}