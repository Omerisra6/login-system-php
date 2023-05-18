<?php

namespace App\Validators;

class Validator
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public static function make($request)
    {
        return new static($request);
    }
}
