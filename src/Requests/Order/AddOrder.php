<?php

namespace App\Requests\Order;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use App\Requests\BaseRequest;

class AddOrder extends BaseRequest
{
    #[NotBlank([])]
    #[GreaterThan(0)]
    public $price;

    #[Type('string')]
    public $voucherCode;

}