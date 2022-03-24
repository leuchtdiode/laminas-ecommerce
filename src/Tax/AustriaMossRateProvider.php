<?php
namespace Ecommerce\Tax;

class AustriaMossRateProvider implements RateProvider
{
	const TAX_RATES = [
		'BE' => 21,
		'BG' => 20,
		'DK' => 25,
		'DE' => 19,
		'EE' => 20,
		'FI' => 24,
		'FR' => 20,
		'GR' => 24,
		'IE' => 23,
		'IT' => 22,
		'HR' => 25,
		'LV' => 21,
		'LT' => 21,
		'LU' => 17,
		'MT' => 18,
		'NL' => 21,
		'AT' => 20,
		'PL' => 23,
		'PT' => 23,
		'RO' => 19,
		'SE' => 25,
		'SK' => 20,
		'SI' => 22,
		'ES' => 21,
		'CZ' => 21,
		'HU' => 27,
		'GB' => 20,
		'CY' => 19,
	];

	const AUSTRIA = 'AT';

	public function get(GetData $data): GetResult
	{
		$result = new GetResult();

		$country    = $data->getCountry();
		$isBusiness = $data->isBusiness();

		if ($country->getIsoCode() === self::AUSTRIA)
		{
			$result->setRate(
				self::TAX_RATES[self::AUSTRIA]
			);

			return $result;
		}

		if ($isBusiness)
		{
			$result->setRate(0);

			return $result;
		}

		$result->setRate(self::TAX_RATES[$country->getIsoCode()] ?? 0);

		return $result;
	}
}