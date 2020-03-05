<?php
namespace Ecommerce\Product;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Status implements ArrayHydratable
{
	const ACTIVE   = 'active';
	const INACTIVE = 'inactive';

	use IdLabelObject;
}