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
	/**
	 * @var RequestData
	 */
	private $data;

	/**
	 * @var Provider
	 */
	private $customerProvider;

	/**
	 * @var ForgotPasswordHandler
	 */
	private $forgotPasswordHandler;

	/**
	 * @param RequestData $data
	 * @param Provider $customerProvider
	 * @param ForgotPasswordHandler $forgotPasswordHandler
	 */
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
	 * @return JsonModel
	 * @throws Exception
	 */
	public function executeAction()
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
