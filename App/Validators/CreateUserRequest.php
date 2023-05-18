<?php

namespace App\Validators;

use App\Utils\DB;

class CreateUserRequest extends Validator
{
    public function validate()
    {
        $username         = preg_replace('/\s+/', '', $this->request['username']);
        $password         = $this->request[ 'password' ];
        $password_confirm = $this->request[ 'password_confirm' ];

        if (! isset($username) || !  isset($password) || ! isset($password_confirm)) {
            throw new \Exception('Please fill all required fields', 400);
        }

        if ($password !== $password_confirm) {
            throw new \Exception('Passwords don\'t match', 400);
        }

        if (DB::table('users')->where('username', null, $username)) {
            throw new \Exception('User already exists', 409);
        }
    }
}
