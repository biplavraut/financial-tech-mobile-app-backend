<?php

namespace App\Custom\SocialLogin\Abstracts;

abstract class SocialLogin
{
    protected $valid = false;
    protected $request;
    protected $errorMessages = [];
    protected $errorCode = 404;

    public function __construct($request = null)
    {
        $this->request = $request ?: request();
    }

    abstract public function verify();

    public function isValid()
    {
        return $this->valid;
    }

    protected function getToken()
    {
        return $this->request->input('token');
    }

    protected function getEmail()
    {
        return $this->request->input('email');
    }

    protected function getPassword()
    {
        return $this->request->input('password');
    }

    protected function getFrom()
    {
        return $this->request->input('from');
    }

    public function getErrorMessages()
    {
        return implode(', ', array_unique($this->errorMessages));
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
