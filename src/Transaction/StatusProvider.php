<?php
namespace Ecommerce\Transaction;

use Common\Translator;

class StatusProvider
{
	/**
	 * @return Status[]
	 */
	public function all()
	{
		return [
			$this->create(Status::NEW, _('Neu')),
			$this->create(Status::PENDING, _('In Bearbeitung')),
			$this->create(Status::CANCELLED, _('Abgebrochen')),
			$this->create(Status::ERROR, _('Fehler')),
			$this->create(Status::SUCCESS, _('Erfolgreich')),
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