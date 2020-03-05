<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Ecommerce\Customer\Password\ChangeHandler;
use Exception;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Laminas\View\Model\JsonModel;

class Change extends Base
{
	/**
	 * @var ChangeData
	 */
	private $data;

	/**
	 * @var ChangeHandler
	 */
	private $changeHandler;

	/**
	 * @param ChangeData $data
	 * @param ChangeHandler $changeHandler
	 */
	public function __construct(ChangeData $data, ChangeHandler $changeHandler)
	{
		$this->data          = $data;
		$this->changeHandler = $changeHandler;
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function executeAction()
	{
		$customerId = $this
			->params()
			->fromRoute('id');

		if (!$this->customerCheck($customerId))
		{
			return $this->forbidden();
		}

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

		$result = $this->changeHandler->change(
			$this->getCustomer(),
			$values
				->get(ChangeData::PASSWORD)
				->getValue(),
			$values
				->get(ChangeData::PASSWORD_NEW)
				->getValue(),
			$values
				->get(ChangeData::PASSWORD_NEW_VERIFY)
				->getValue()
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
