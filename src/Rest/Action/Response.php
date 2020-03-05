<?php
namespace Ecommerce\Rest\Action;

use Common\Error;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Laminas\View\Model\JsonModel;

class Response
{
	/**
	 * @var bool
	 */
	private $success;

	/**
	 * @var Error[]
	 */
	private $errors;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @return Response
	 */
	public static function is()
	{
		return new self();
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function dispatch()
	{
		return new JsonModel(
			[
				'success' => $this->success,
				'data'    => $this->data,
				'errors'  => ObjectToArrayHydrator::hydrate($this->errors),
			]
		);
	}

	/**
	 * @return Response
	 */
	public function successful(): Response
	{
		$this->success = true;

		return $this;
	}

	/**
	 * @return Response
	 */
	public function unsuccessful(): Response
	{
		$this->success = false;

		return $this;
	}

	/**
	 * @param Error[] $errors
	 * @return Response
	 */
	public function errors(array $errors): Response
	{
		$this->errors = $errors;

		return $this;
	}

	/**
	 * @param array $data
	 * @return Response
	 */
	public function data(array $data): Response
	{
		$this->data = $data;

		return $this;
	}
}
