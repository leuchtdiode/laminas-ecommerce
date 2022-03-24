<?php
namespace Ecommerce\Common;

use Common\Db\Entity;
use Common\Dto\Dto;

interface EntityDtoCreator
{
	public function byEntity(Entity $entity): Dto;
}