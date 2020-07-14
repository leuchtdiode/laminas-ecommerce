<?php
namespace Ecommerce\Rest\Action\Invoice;

use Exception;
use DateTime;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Transaction\Invoice\Bulk\GetData;
use Ecommerce\Transaction\Invoice\Bulk\Provider;

class Bulk extends Base implements LoginExempt
{
	/**
	 * @var BulkData
	 */
	private $data;
	
	/**
	 * @var Provider
	 */
	private $bulkProvider;

	/**
	 * @param BulkData $data
	 * @param Provider $bulkProvider
	 */
	public function __construct(BulkData $data, Provider $bulkProvider)
	{
		$this->data         = $data;
		$this->bulkProvider = $bulkProvider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction()
	{
		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return $this->notFound();
		}

		$result = $this->bulkProvider->get(
			GetData::create()
				->setDateStart(
					new DateTime(
						$values->getRawValue(BulkData::DATE_START)
					)
				)
				->setDateEnd(
					new DateTime(
						$values->getRawValue(BulkData::DATE_END)
					)
				)
		);

		if (!$result->hasContent())
		{
			return $this->notFound();
		}

		$content = $result->getContent();

		$response = $this->getResponse();

		$response
			->getHeaders()
			->addHeaders(
				[
					'Content-type' => 'application/pdf;charset=utf-8',
				]
			);

		$response->setContent($content);

		return $response;
	}
}