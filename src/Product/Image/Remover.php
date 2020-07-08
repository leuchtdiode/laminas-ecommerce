<?php
namespace Ecommerce\Product\Image;

use Common\Db\EntityDeleter;
use Common\Db\FilterChain;
use Ecommerce\Db\Product\Image\Filter\Product as ProductImageFilterProduct;
use Exception;
use Log\Log;

class Remover
{
	/**
	 * @var Provider
	 */
	private $provider;

	/**
	 * @var EntityDeleter
	 */
	private $entityDeleter;

	/**
	 * @param Provider $provider
	 * @param EntityDeleter $entityDeleter
	 */
	public function __construct(Provider $provider, EntityDeleter $entityDeleter)
	{
		$this->provider      = $provider;
		$this->entityDeleter = $entityDeleter;
	}

	/**
	 * @param RemoveData $data
	 * @return RemoveResult
	 * @throws Exception
	 */
	public function remove(RemoveData $data)
	{
		$result = new RemoveResult();
		$result->setSuccess(true);

		$image   = $data->getImage();
		$product = $data->getProduct();

		if (!$image && !$product)
		{
			throw new Exception('Neither image nor product given');
		}

		$imagesToRemove = [];

		if ($image)
		{
			$imagesToRemove = [ $image ];
		}

		if ($product)
		{
			$imagesToRemove = $this->provider->filter(
				FilterChain::create()
					->addFilter(ProductImageFilterProduct::is($product->getId()))
			);
		}

		foreach ($imagesToRemove as $imageToRemove)
		{
			try
			{
				$this->entityDeleter->delete(
					$imageToRemove->getEntity()
				);

				// TODO remove assets file
			}
			catch (Exception $ex)
			{
				Log::error($ex);

				$result->setSuccess(false);
			}
		}

		return $result;
	}
}