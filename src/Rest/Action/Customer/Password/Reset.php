<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Ecommerce\Customer\CouldNotFindCustomerError;
use Ecommerce\Customer\Password\ResetHandler;
use Ecommerce\Customer\Provider;
use Ecommerce\Rest\Action\LoginExempt;
use Exception;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Ecommerce\Customer\Password\ResetData as CustomerPasswordResetData;
use Laminas\View\Model\JsonModel;

class Reset extends Base implements LoginExempt
{
	private ResetData $data;

	private Provider $customerProvider;

	private ResetHandler $resetHandler;

	public function __construct(ResetData $data, Provider $customerProvider, ResetHandler $resetHandler)
	{
		$this->data             = $data;
		$this->customerProvider = $customerProvider;
		$this->resetHandler     = $resetHandler;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($values->getErrors())
				->dispatch();
		}

		$customer = $this->customerProvider->byId(
			$this->params()
				->fromRoute('id')
		);

		if (!$customer)
		{
			return Response::is()
				->unsuccessful()
				->errors([ CouldNotFindCustomerError::create() ])
				->dispatch();
		}

		$result = $this->resetHandler->reset(
			CustomerPasswordResetData::create()
				->setCustomer($customer)
				->setHash(
					$values
						->get(ResetData::HASH)
						->getValue()
				)
				->setPassword(
					$values
						->get(ResetData::PASSWORD)
						->getValue()
				)
				->setPasswordVerify(
					$values
						->get(ResetData::PASSWORD_VERIFY)
						->getValue()
				)
		);

		if (!$result->isSuccess())
		{
			return Response::is()
				->unsuccessful()
				->errors($result->getErrors())
				->dispatch();
		}

		return Response::is()
			->successful()
			->dispatch();
	}
}
