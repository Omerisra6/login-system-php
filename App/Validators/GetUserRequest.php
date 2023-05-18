<?php

namespace App\Validators;

class GetUserRequest extends Validator
{
    public function validate()
    {
        if (! isset($_SESSION[ 'id' ])) {
            throw new \Exception(_('User is not logged in'), 400);
        }

        if (! isset($request[ 'id' ])) {
            throw new \Exception(_('User not found'), 404);
        }
    }
}
