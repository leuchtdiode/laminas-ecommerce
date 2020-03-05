<?php
namespace Ecommerce\Customer;

use Common\Translator;

class SalutationProvider
{
	/**
	 * @return Salutation[]
	 */
	public function all()
	{
		return [
			$this->create(Salutation::MALE, _('Herr')),
			$this->create(Salutation::FEMALE, _('Frau')),
			$this->create(Salutation::X, _('X')),
		];
	}

	/**
	 * @param string $id
	 * @return Salutation|null
	 */
	public function byId($id)
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

	/**
	 * @param string $id
	 * @param string $label
	 * @return Salutation
	 */
	private function create($id, $label)
	{
		return new Salutation($id, Translator::translate($label));
	}
}