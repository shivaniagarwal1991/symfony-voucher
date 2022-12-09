<?php

namespace App\Helper\Abstract;

use App\Contract\Voucher;

abstract class AbstractCodeGenerator
{
    protected $maxRetries = Voucher::VOUCHER_GENERATION_MAX_RETRY;

    protected function generateCode(): string
    {
        return substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, Voucher::VOUCHER_LENGTH);
    }

    abstract public function getUniqueCode();

}