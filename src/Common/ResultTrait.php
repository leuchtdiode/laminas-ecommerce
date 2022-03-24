<?php
namespace Ecommerce\Common;

use Common\Error;

trait ResultTrait
{
	private bool $success;

	/**
	 * @var Error[]
	 */
	private array $errors = [];

	public function addError(Error $error): self
	{
		$this->errors[] = $error;

		return $this;
	}

	public function setErrors(array $errors): self
	{
		$this->errors = $errors;
		return $this;
	}

	public function setSuccess(bool $success): self
	{
		$this->success = $success;

		return $this;
	}

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