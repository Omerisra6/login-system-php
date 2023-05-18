<?php

namespace App\Validators;

use App\Utils\DB;

class LoginUserRequest extends Validator
{
    public function validate()
    {
        if (! isset($this->request[ 'username' ]) || ! isset($this->request[ 'password' ])) {
            throw new \Exception(_('Please fill all required fields'), 400);
        }

        $username = preg_replace('/\s+/', '', $this->request[ 'username' ]) ?? null;
        $password = $this->request[ 'password' ] ?? null;

        if (! $username || ! $password) {
            throw new \Exception(_('Please fill all required fields'), 400);
        }


        if (! DB::table('users')->where('username', null, $username)) {
            throw new \Exception(_('User not found'), 404);
        }

        return [ 'username' => $username, 'password' => $password ];
    }
}
