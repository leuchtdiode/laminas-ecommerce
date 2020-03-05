<?php
namespace Ecommerce\Product;

use Common\Translator;

class StatusProvider
{
	/**
	 * @return Status[]
	 */
	public function all()
	{
		return [
			$this->create(Status::ACTIVE, _('Aktiv')),
			$this->create(Status::INACTIVE, _('Inaktiv')),
		];
	}

	/**
	 * @param string $id
	 * @return Status|null
	 */
	public function byId($id)
	{
		foreach ($this->all() as $status)
		{
			if ($status->is($id))
			{
				return $status;
			}
		}

		return null;
	}

	/**
	 * @param string $id
	 * @param string $label
	 * @return Status
	 */
	private function create($id, $label)
	{
		return new Status($id, Translator::translate($label));
	}
}