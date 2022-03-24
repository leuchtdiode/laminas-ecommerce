<?php
namespace Ecommerce\Customer\Auth;

class PasswordHandler
{
	public function hash(string $password): string
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function verify(string $password, string $hash): string
	{
		return password_verify($password, $hash);
	}
}