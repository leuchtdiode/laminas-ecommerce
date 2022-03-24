<?php
namespace Ecommerce\Customer;

use Common\Translator;

class StatusProvider
{
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

	/**
	 * @return Status[]
	 */
	private function all(): array
	{
		return [
			$this->create(Status::PENDING_VERIFICATION, _('Wartet auf Aktivierung')),
			$this->create(Status::ACTIVE, _('Aktiv')),
		];
	}

	private function create(string $id, string $label): Status
	{
		return new Status($id, Translator::translate($label));
	}
}