<?php
namespace Ecommerce\Rest\Action;

use Ecommerce\Customer\Customer;
use Ecommerce\Rest\Action\Plugin\Auth;
use Laminas\Http\Request;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\Mvc\MvcEvent;

/**
 * @method Auth auth()
 */
abstract class Base extends AbstractRestfulController
{
	/**
	 * @var Customer|null
	 */
	private $customer;

	/**
	 * @param MvcEvent $e
	 * @return mixed
	 */
	public function onDispatch(MvcEvent $e)
	{
		$request  = $e->getRequest();
		$response = $e->getResponse();

		$this->loadCustomer($request);

		if (!$this instanceof LoginExempt && !$this->customer) // needs login, but not logged in
		{
			return $this->forbidden();
		}

		if ($this->customer)
		{
			$response->getHeaders()->addHeaders(
				[
					'X-JwtToken' => $this
						->auth()
						->generateJwtToken($this->customer)
				]
			);
		}

		return parent::onDispatch($e);
	}

	abstract public function executeAction();

	/**
	 * @param Request $request
	 */
	protected function loadCustomer($request)
	{
		$authHeader = $request
			->getHeader('Authorization');

		if (!$authHeader)
		{
			return;
		}

		$token = $authHeader->getFieldValue();

		if (!$token)
		{
			return;
		}

		$result = $this->auth()->validateJwtToken($token);

		if (!$result->isValid())
		{
			return;
		}

		$this->customer = $result->getCustomer();
	}

	/**
	 * @return Customer|null
	 */
	protected function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	/**
	 * @param string $customerId
	 * @return bool
	 */
	protected function customerCheck($customerId)
	{
		return $this->customer && $this->customer->getId()->toString() === $customerId;
	}

	/**
	 * @return mixed
	 */
	protected function forbidden()
	{
		return $this
			->getResponse()
			->setStatusCode(403);
	}

	/**
	 * @return mixed
	 */
	protected function notFound()
	{
		return $this
			->getResponse()
			->setStatusCode(404);
	}
}
