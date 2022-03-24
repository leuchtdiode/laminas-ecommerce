<?php
namespace Ecommerce\Transaction;

use Common\Translator;

class StatusProvider
{
	/**
	 * @return Status[]
	 */
	public function all(): array
	{
		return [
			$this->create(Status::NEW, _('Neu')),
			$this->create(Status::PENDING, _('In Bearbeitung')),
			$this->create(Status::CANCELLED, _('Abgebrochen')),
			$this->create(Status::ERROR, _('Fehler')),
			$this->create(Status::SUCCESS, _('Erfolgreich')),
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