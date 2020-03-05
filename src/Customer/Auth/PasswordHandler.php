<?php
namespace Ecommerce\Customer\Auth;

class PasswordHandler
{
	/**
	 * @param string $password
	 * @return string
	 */
	public function hash($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * @param string $password
	 * @param string $hash
	 * @return string
	 */
	public function verify($password, $hash)
	{
		return password_verify($password, $hash);
	}
}