<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Db\Product\Attribute\Value\Saver as EntitySaver;
use Exception;
use Log\Log;

class Saver
{
	/**
	 * @var Provider
	 */
	private $provider;

	/**
	 * @var EntitySaver
	 */
	private $entitySaver;

	/**
	 * @param Provider $provider
	 * @param EntitySaver $entitySaver
	 */
	public function __construct(Provider $provider, EntitySaver $entitySaver)
	{
		$this->provider    = $provider;
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

		$attributeValue = $data->getAttributeValue();

		try
		{
			$entity = $attributeValue
				? $attributeValue->getEntity()
				: new Entity();

			$entity->setValue(
				$data->getValue()
			);
			$entity->setAttribute(
				$data
					->getAttribute()
					->getEntity()
			);

			$this->entitySaver->save($entity);

			$result->setValue(
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