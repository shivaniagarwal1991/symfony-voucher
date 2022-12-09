<?php

namespace App\Requests\Voucher;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\GreaterThan;
use App\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditVoucher extends BaseRequest
{
    #[NotBlank()]
    #[GreaterThan(0)]
    public $discount;

    #[NotBlank()]
    #[DateTime("Y-m-d H:i:s")]
    public $expired;

    #[NotBlank()]
    #[Choice([1, 2, 3])]
    public $status;

}