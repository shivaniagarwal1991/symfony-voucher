<?php

namespace App\Requests\User;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Email;
use App\Requests\BaseRequest;

class AddUser extends BaseRequest
{
    #[NotBlank([])]
    #[Email([])]
    public $email;

    #[NotBlank()]
    public $password;

    #[Type('string')]
    #[NotBlank()]
    #[Choice(['creator', 'admin'])]
    public $role;

}