<?php

namespace App\Requests\User;

use Symfony\Component\Validator\Constraints\NotBlank;
use App\Requests\BaseRequest;

class EditUser extends BaseRequest
{
    #[NotBlank()]
    public $password;

}