<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Ecommerce\Customer\Auth\ForgotPasswordHandler;
use Ecommerce\Customer\CouldNotFindCustomerError;
use Ecommerce\Customer\Provider;
use Ecommerce\Rest\Action\LoginExempt;
use Exception;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Laminas\View\Model\JsonModel;

class Request extends Base implements LoginExempt
{
	private RequestData $data;

	private Provider $customerProvider;

	private ForgotPasswordHandler $forgotPasswordHandler;

	public function __construct(
		RequestData $data,
		Provider $customerProvider,
		ForgotPasswordHandler $forgotPasswordHandler
	)
	{
		$this->data                  = $data;
		$this->customerProvider      = $customerProvider;
		$this->forgotPasswordHandler = $forgotPasswordHandler;
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

		$email = $values
			->get(RequestData::EMAIL)
			->getValue();

		$customer = $this->customerProvider->byEmail($email);

		if (!$customer)
		{
			return Response::is()
				->unsuccessful()
				->errors([ CouldNotFindCustomerError::create() ])
				->dispatch();
		}

		$result = $this->forgotPasswordHandler->forgotPassword($customer);

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
