<?php

namespace App\Message;

class Message
{
    const USER_ALREADY_EXIST = 'user.already.exist';
    const USER_SUCCESSFULLY_CREATED = 'user.successfully.created';
    const USER_NOT_FOUND = 'user.not.found';
    const USER_UPDATE_USER = 'user.updated';
    const VOUCHER_CODE_CONFLICT = 'voucher.code.conflict';
    const VOUCHER_NOT_FOUND = 'voucher.not.found';
    const VOUCHER_EDIT_NOT_ALLOWED = 'voucher.edit.not.allowed';
    const VOUCHER_AMOUNT_MORE_THAN_PRICE = 'voucher.amount.more.than.price';
    const VOUCHER_EXPIRED = 'voucher.expired';
    const VOUCHER_USED = 'voucher.used';
}