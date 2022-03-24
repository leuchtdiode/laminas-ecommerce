<?php
namespace Ecommerce\Transaction;

use Common\Translator;

class PostPaymentStatusProvider
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return PostPaymentStatus[]
	 */
	public function all(): array
	{
		$all = [];

		$postPaymentStatus = $this->config['ecommerce']['transaction']['postPaymentStatus']['set'] ?? [];

		foreach ($postPaymentStatus as $id => $label)
		{
			$all[] = new PostPaymentStatus($id, Translator::translate($label));
		}

		return $all;
	}

	public function byId(string $id): ?PostPaymentStatus
	{
		foreach ($this->all() as $item)
		{
			if ($item->is($id))
			{
				return $item;
			}
		}

		return null;
	}
}