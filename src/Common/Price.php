<?php
namespace Ecommerce\Common;

use Common\Hydration\ArrayHydratable;
use Common\Translator;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\MoneyFormatter;
use NumberFormatter;

class Price implements ArrayHydratable
{
	/**
	 * @var Money
	 */
	private $money;

	/**
	 * @var Money
	 */
	private $grossMoney;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var int
	 */
	private $taxRate;

	/**
	 * @var MoneyFormatter
	 */
	private $formatter;

	/**
	 * @param Money $money
	 * @param int $taxRate
	 */
	public function __construct(Money $money, int $taxRate)
	{
		$this->money   = $money;
		$this->taxRate = $taxRate;

		$this->grossMoney = $money->multiply(1 + ($this->taxRate / 100));

		$currencies = new ISOCurrencies();

		$numberFormatter = new NumberFormatter(Translator::getLocale(), NumberFormatter::DECIMAL);
		$numberFormatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

		$this->formatter = new IntlMoneyFormatter($numberFormatter, $currencies);
	}

	/**
	 * @param $cents
	 * @param int $taxRate
	 * @return Price
	 */
	public static function fromCents($cents, $taxRate)
	{
		return new self(
			Money::EUR($cents),
			$taxRate
		);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getNet()
	{
		return $this->money->getAmount();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getNetFormatted()
	{
		return $this->formatter->format($this->money);
	}

	/**
	 * @return int
	 */
	public function getTaxRate(): int
	{
		return $this->taxRate;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->money
			->getCurrency()
			->getCode();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getGross()
	{
		return $this->grossMoney->getAmount();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getGrossFormatted()
	{
		return $this->formatter->format($this->grossMoney);
	}
}