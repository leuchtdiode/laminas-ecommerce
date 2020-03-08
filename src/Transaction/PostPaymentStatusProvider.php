<?php
namespace Ecommerce\Transaction;

use Common\Translator;

class PostPaymentStatusProvider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * PostPaymentStatusProvider constructor.
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return PostPaymentStatus[]
	 */
	public function all()
	{
		$all = [];

		$postPaymentStatus = $this->config['ecommerce']['transaction']['postPaymentStatus']['set'] ?? [];

		foreach ($postPaymentStatus as $id => $label)
		{
			$all[] = new PostPaymentStatus($id, Translator::translate($label));
		}

		return $all;
	}

	/**
	 * @param $id
	 * @return PostPaymentStatus|null
	 */
	public function byId($id)
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