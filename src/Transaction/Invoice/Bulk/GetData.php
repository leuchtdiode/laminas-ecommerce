<?php
namespace Ecommerce\Transaction\Invoice\Bulk;

use DateTime;

class GetData
{
	private DateTime $dateStart;

	private DateTime $dateEnd;

	public static function create(): self
	{
		return new self();
	}

	public function getDateStart(): DateTime
	{
		return $this->dateStart;
	}

	public function setDateStart(DateTime $dateStart): GetData
	{
		$this->dateStart = $dateStart;
		return $this;
	}

	public function getDateEnd(): DateTime
	{
		return $this->dateEnd;
	}

	public function setDateEnd(DateTime $dateEnd): GetData
	{
		$this->dateEnd = $dateEnd;
		return $this;
	}
}