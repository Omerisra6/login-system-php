<?php

namespace App\Validators;

class GetLoggedUsersRequest extends Validator
{
    public function validate()
    {
        if (! isset($_SESSION[ 'id' ])) {
            throw new \Exception(_('User is not logged in'), 400);
        }
    }
}
