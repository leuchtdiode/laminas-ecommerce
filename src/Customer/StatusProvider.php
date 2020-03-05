<?php
namespace Ecommerce\Customer;

use Common\Translator;

class StatusProvider
{
	/**
	 * @param $id
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
	 * @return array
	 */
	private function all()
	{
		return [
			$this->create(Status::PENDING_VERIFICATION, _('Wartet auf Aktivierung')),
			$this->create(Status::ACTIVE, _('Aktiv')),
		];
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