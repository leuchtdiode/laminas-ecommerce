<?php
namespace Ecommerce\Rest\Action;

use Common\Error;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Laminas\View\Model\JsonModel;

class Response
{
	private bool $success;

	/**
	 * @var Error[]
	 */
	private array $errors = [];

	private array $data;

	public static function is(): self
	{
		return new self();
	}

	/**
	 * @throws Exception
	 */
	public function dispatch(): JsonModel
	{
		return new JsonModel(
			[
				'success' => $this->success,
				'data'    => $this->data,
				'errors'  => ObjectToArrayHydrator::hydrate($this->errors),
			]
		);
	}

	public function successful(): Response
	{
		$this->success = true;

		return $this;
	}

	public function unsuccessful(): Response
	{
		$this->success = false;

		return $this;
	}

	/**
	 * @param Error[] $errors
	 */
	public function errors(array $errors): Response
	{
		$this->errors = $errors;

		return $this;
	}

	public function data(array $data): Response
	{
		$this->data = $data;

		return $this;
	}
}
