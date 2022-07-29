<?php
namespace Ecommerce\Common;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\MoneyFormatter;
use NumberFormatter;

class Price implements ArrayHydratable
{
	private Money $money;

	private Money $grossMoney;

	#[ObjectToArrayHydratorProperty]
	private int $taxRate;

	private Money $taxAmount;

	private MoneyFormatter $formatter;

	public function __construct(Money $money, int $taxRate)
	{
		$this->money   = $money;
		$this->taxRate = $taxRate;

		$this->grossMoney = $money->multiply((string)(1 + ($this->taxRate / 100)));
		$this->taxAmount = $this->grossMoney->subtract($this->money);

		$currencies = new ISOCurrencies();

		$numberFormatter = new NumberFormatter(Translator::getLocale(), NumberFormatter::DECIMAL);
		$numberFormatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

		$this->formatter = new IntlMoneyFormatter($numberFormatter, $currencies);
	}

	public static function fromCents(int $cents, int $taxRate): self
	{
		return new self(
			Money::EUR($cents),
			$taxRate
		);
	}

	#[ObjectToArrayHydratorProperty]
	public function getNet(): string
	{
		return $this->money->getAmount();
	}

	#[ObjectToArrayHydratorProperty]
	public function getNetFormatted(): string
	{
		return $this->formatter->format($this->money);
	}

	public function getTaxRate(): int
	{
		return $this->taxRate;
	}

	#[ObjectToArrayHydratorProperty]
	public function getCurrency(): string
	{
		return $this->money
			->getCurrency()
			->getCode();
	}

	#[ObjectToArrayHydratorProperty]
	public function getGross(): string
	{
		return $this->grossMoney->getAmount();
	}

	#[ObjectToArrayHydratorProperty]
	public function getGrossFormatted(): string
	{
		return $this->formatter->format($this->grossMoney);
	}

	#[ObjectToArrayHydratorProperty]
	public function getTaxAmount(): string
	{
		return $this->taxAmount->getAmount();
	}

	#[ObjectToArrayHydratorProperty]
	public function getTaxAmountFormatted(): string
	{
		return $this->formatter->format($this->taxAmount);
	}
}