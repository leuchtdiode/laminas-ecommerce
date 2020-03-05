<?php
namespace Ecommerce\Product\Image;

use Assets\Common\DtoCreatorProvider as AssetsDtoCreatorProvider;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Product\Image\Entity;

class Creator implements EntityDtoCreator
{
	/**
	 * @var AssetsDtoCreatorProvider
	 */
	private $assetsDtoCreatorProvider;

	/**
	 * @param AssetsDtoCreatorProvider $assetsDtoCreatorProvider
	 */
	public function __construct(AssetsDtoCreatorProvider $assetsDtoCreatorProvider)
	{
		$this->assetsDtoCreatorProvider = $assetsDtoCreatorProvider;
	}

	/**
	 * @param Entity $entity
	 * @return Image
	 */
	public function byEntity($entity)
	{
		return new Image(
			$entity,
			$this->assetsDtoCreatorProvider
				->getFileCreator()
				->byEntity($entity->getFile())
		);
	}
}