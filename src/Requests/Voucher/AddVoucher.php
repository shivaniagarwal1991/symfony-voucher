<?php

namespace App\Requests\Voucher;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use App\Requests\BaseRequest;

class AddVoucher extends BaseRequest
{
    #[NotBlank([])]
    #[GreaterThan(0)]
    public $discount;

    #[NotBlank()]
    #[Choice([1])]
    public $status;

    #[DateTime("Y-m-d H:i:s")]
    #[NotBlank()]
    public $expired;

}