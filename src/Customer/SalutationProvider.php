<?php
namespace Ecommerce\Customer;

use Common\Translator;

class SalutationProvider
{
	/**
	 * @return Salutation[]
	 */
	public function all(): array
	{
		return [
			$this->create(Salutation::MALE, _('Herr')),
			$this->create(Salutation::FEMALE, _('Frau')),
			$this->create(Salutation::X, _('X')),
		];
	}

	public function byId(string $id): ?Salutation
	{
		foreach ($this->all() as $salutation)
		{
			if ($salutation->is($id))
			{
				return $salutation;
			}
		}

		return null;
	}

	private function create(string $id, string $label): Salutation
	{
		return new Salutation($id, Translator::translate($label));
	}
}