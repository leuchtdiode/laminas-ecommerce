<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Db\FilterChain;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Db\Product\Attribute\Value\Filter\Attribute as AttributeFilter;
use Ecommerce\Db\Product\Attribute\Value\Filter\Value as ValueFilter;
use Ecommerce\Db\Product\Attribute\Value\Saver as EntitySaver;
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

		$attributeValue = $data->getAttributeValue();
		$value          = $data->getValue();
		$attribute      = $data->getAttribute();

		$alreadyIn = $this->provider->filter(
			FilterChain::create()
				->addFilter(
					ValueFilter::is($value)
				)
				->addFilter(
					AttributeFilter::is($attribute->getId())
				)
		);

		if ($alreadyIn)
		{
			$result->setValue(reset($alreadyIn));
			$result->setSuccess(true);

			return $result;
		}

		try
		{
			$entity = $attributeValue
				? $attributeValue->getEntity()
				: new Entity();

			$entity->setValue($value);
			$entity->setAttribute(
				$attribute->getEntity()
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