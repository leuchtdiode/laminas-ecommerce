<?php
namespace Ecommerce\Customer\Auth;

class LoginData
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @return LoginData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return LoginData
	 */
	public function setEmail(string $email): LoginData
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return LoginData
	 */
	public function setPassword(string $password): LoginData
	{
		$this->password = $password;
		return $this;
	}
}