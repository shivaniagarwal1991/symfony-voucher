<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyExistExeption extends ConflictHttpException
{

}