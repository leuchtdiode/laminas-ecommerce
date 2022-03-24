<?php
namespace Ecommerce\Payment;

use Common\Translator;

class MethodProvider
{
	/**
	 * @return Method[]
	 */
	public function all(): array
	{
		return [
			$this->create(Method::PAY_PAL, _('PayPal')),
			$this->create(Method::AMAZON_PAY, _('Amazon Pay')),
			$this->create(Method::PRE_PAYMENT, _('Vorkasse')),
			$this->create(Method::WIRECARD, _('Wirecard')),
			$this->create(Method::MPAY_24, _('Mpay24')),
		];
	}

	public function byId(string $id): ?Method
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

	private function create(string $id, string $label): Method
	{
		return new Method($id, Translator::translate($label));
	}
}