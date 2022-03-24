<?php
namespace Ecommerce\Customer\Auth;

class LoginData
{
	private string $email;

	private string $password;

	public static function create(): self
	{
		return new self();
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): LoginData
	{
		$this->email = $email;
		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): LoginData
	{
		$this->password = $password;
		return $this;
	}
}