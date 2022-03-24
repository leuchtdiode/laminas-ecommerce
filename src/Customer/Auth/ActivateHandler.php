<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\CouldNotFindCustomerError;
use Ecommerce\Customer\Provider;
use Ecommerce\Customer\Status;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class ActivateHandler
{
	private Provider $customerProvider;

	private Saver $entitySaver;

	public function __construct(Provider $customerProvider, Saver $entitySaver)
	{
		$this->customerProvider = $customerProvider;
		$this->entitySaver      = $entitySaver;
	}

	public function activate(string $customerId, string $createdDate): ActivateResult
	{
		$result = new ActivateResult();
		$result->setSuccess(false);

		$customer = $this->customerProvider->byId($customerId);

		if (!$customer)
		{
			$result->addError(CouldNotFindCustomerError::create());

			return $result;
		}

		if (!$customer->getStatus()->isPendingVerification())
		{
			return $result;
		}

		if ($customer->getCreatedDate()->format('Y-m-d') !== $createdDate)
		{
			return $result;
		}

		try
		{
			$entity = $customer->getEntity();
			$entity->setStatus(Status::ACTIVE);

			$this->entitySaver->save(
				$entity
			);

			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}