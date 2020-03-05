<?php
namespace Ecommerce\Common;

use Common\Error;

trait ResultTrait
{
	/**
	 * @var bool
	 */
	private $success;

	/**
	 * @var Error[]
	 */
	private $errors = [];

	/**
	 * @param Error $error
	 * @return $this
	 */
	public function addError(Error $error)
	{
		$this->errors[] = $error;

		return $this;
	}

	/**
	 * @param Error[] $errors
	 * @return ResultTrait
	 */
	public function setErrors(array $errors)
	{
		$this->errors = $errors;
		return $this;
	}

	/**
	 * @param bool $success
	 * @return ResultTrait
	 */
	public function setSuccess(bool $success)
	{
		$this->success = $success;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSuccess(): bool
	{
		return $this->success;
	}

	/**
	 * @return Error[]
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}