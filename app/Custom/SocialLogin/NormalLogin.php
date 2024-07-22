<?php

namespace App\Custom\SocialLogin;

use App\Custom\SocialLogin\Abstracts\SocialLogin;


class NormalLogin extends SocialLogin
{
	public function verify()
	{
		return $this;
	}

	public function isValid(): bool
	{
		if (auth()->attempt(['email' => $this->getEmail(), 'password' => $this->getPassword(), 'verified' => 1])) {
			return true;
		} else {
			$this->errorMessages[] = 'These credentials do not match our records.';
			$this->errorCode = 401;
			return false;
		}
	}
}
