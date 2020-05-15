<?php
namespace Ecommerce\Transaction\Invoice\Bulk;

use DateTime;

class GetData
{
	/**
	 * @var DateTime
	 */
	private $dateStart;

	/**
	 * @var DateTime
	 */
	private $dateEnd;

	/**
	 * @return GetData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return DateTime
	 */
	public function getDateStart(): DateTime
	{
		return $this->dateStart;
	}

	/**
	 * @param DateTime $dateStart
	 * @return GetData
	 */
	public function setDateStart(DateTime $dateStart): GetData
	{
		$this->dateStart = $dateStart;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getDateEnd(): DateTime
	{
		return $this->dateEnd;
	}

	/**
	 * @param DateTime $dateEnd
	 * @return GetData
	 */
	public function setDateEnd(DateTime $dateEnd): GetData
	{
		$this->dateEnd = $dateEnd;
		return $this;
	}
}