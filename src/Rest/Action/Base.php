<?php
namespace Ecommerce\Rest\Action;

use Ecommerce\Customer\Customer;
use Ecommerce\Rest\Action\Plugin\Auth;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\RequestInterface;
use Laminas\Stdlib\ResponseInterface;

/**
 * @method Auth auth()
 */
abstract class Base extends AbstractRestfulController
{
	private ?Customer $customer = null;

	public function onDispatch(MvcEvent $e): mixed
	{
		$restConfig = $this->config()['ecommerce']['rest'] ?? [];

		if ($restConfig)
		{
			$routeName = $e
				->getRouteMatch()
				->getMatchedRouteName();

			$exclusions = $restConfig['nonDisabledRoutes'] ?? [];

			if (($restConfig['disabled'] ?? false) && !in_array($routeName, $exclusions))
			{
				return $this->forbidden();
			}
		}

		$request  = $e->getRequest();
		$response = $e->getResponse();

		$this->loadCustomer($request);

		if (!$this instanceof LoginExempt && !$this->customer) // needs login, but not logged in
		{
			return $this->forbidden();
		}

		if ($this->customer)
		{
			$response
				->getHeaders()
				->addHeaders(
					[
						'X-JwtToken' => $this
							->auth()
							->generateJwtToken($this->customer),
					]
				);
		}

		return parent::onDispatch($e);
	}

	abstract public function executeAction();

	protected function loadCustomer(RequestInterface $request): void
	{
		$authHeader = $request->getHeader('Authorization');

		if (!$authHeader)
		{
			return;
		}

		$token = $authHeader->getFieldValue();

		if (!$token)
		{
			return;
		}

		$result = $this
			->auth()
			->validateJwtToken($token);

		if (!$result->isValid())
		{
			return;
		}

		$this->customer = $result->getCustomer();
	}

	protected function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	protected function customerCheck(string $customerId): bool
	{
		return $this->customer && $this->customer->getId()
				->toString() === $customerId;
	}

	protected function forbidden(): Response|ResponseInterface
	{
		return $this
			->getResponse()
			->setStatusCode(403);
	}

	protected function notFound(): Response|ResponseInterface
	{
		return $this
			->getResponse()
			->setStatusCode(404);
	}
}
