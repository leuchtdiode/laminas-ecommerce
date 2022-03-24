<?php
namespace Ecommerce\Product;

use Common\Translator;

class StatusProvider
{
	/**
	 * @return Status[]
	 */
	public function all(): array
	{
		return [
			$this->create(Status::ACTIVE, _('Aktiv')),
			$this->create(Status::INACTIVE, _('Inaktiv')),
		];
	}

	public function byId(string $id): ?Status
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

	private function create(string $id, string $label): Status
	{
		return new Status($id, Translator::translate($label));
	}
}