<?php
namespace Ecommerce\Payment;

use Common\Translator;

class MethodProvider
{
	/**
	 * @return Method[]
	 */
	public function all()
	{
		return [
			$this->create(Method::PAY_PAL, _('PayPal')),
			$this->create(Method::AMAZON_PAY, _('Amazon Pay')),
			$this->create(Method::PRE_PAYMENT, _('Vorkasse')),
			$this->create(Method::WIRECARD, _('Wirecard')),
		];
	}

	/**
	 * @param string $id
	 * @return Method|null
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
	 * @return Method
	 */
	private function create($id, $label)
	{
		return new Method($id, Translator::translate($label));
	}
}