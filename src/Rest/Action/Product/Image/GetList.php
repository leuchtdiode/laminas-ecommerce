<?php
namespace Ecommerce\Rest\Action\Product\Image;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Db\Product\Image\Filter\Product;
use Ecommerce\Db\Product\Image\Order\Sort;
use Ecommerce\Product\CouldNotFindProductError;
use Ecommerce\Product\Image\Provider as ImageProvider;
use Ecommerce\Product\Provider as ProductProvider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\View\Model\JsonModel;

class GetList extends Base implements LoginExempt
{
	private ProductProvider $productProvider;

	private ImageProvider $imageProvider;

	public function __construct(ProductProvider $productProvider, ImageProvider $imageProvider)
	{
		$this->productProvider = $productProvider;
		$this->imageProvider   = $imageProvider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$product = $this->productProvider->byId(
			$this
				->params()
				->fromRoute('productId')
		);

		if (!$product)
		{
			return Response::is()
				->unsuccessful()
				->errors([CouldNotFindProductError::create()])
				->dispatch();
		}

		$filterChain = FilterChain::create()
			->addFilter(Product::is($product->getId()));

		$orderChain = OrderChain::create()
			->addOrder(Sort::asc());

		$images = $this->imageProvider->filter($filterChain, $orderChain);

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					$images
				)
			)
			->dispatch();
	}
}
