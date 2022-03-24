<?php
namespace Ecommerce\Product\Image;

use Assets\Common\DtoCreatorProvider as AssetsDtoCreatorProvider;
use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Product\Image\Entity;

class Creator implements EntityDtoCreator
{
	private AssetsDtoCreatorProvider $assetsDtoCreatorProvider;

	public function __construct(AssetsDtoCreatorProvider $assetsDtoCreatorProvider)
	{
		$this->assetsDtoCreatorProvider = $assetsDtoCreatorProvider;
	}

	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Image
	{
		return new Image(
			$entity,
			$this->assetsDtoCreatorProvider
				->getFileCreator()
				->byEntity($entity->getFile())
		);
	}
}