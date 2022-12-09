<?php

namespace App\Adapter;

use App\Entity\Voucher as VoucherEntity;
use App\Requests\Voucher\AddVoucher;
use App\Requests\Voucher\EditVoucher;

class VoucherAdaptor
{
    public static function adapt(AddVoucher $voucher) : VoucherEntity
    {
        $dateTime = new \DateTime();
        $expiredAt = new \DateTime('@'.strtotime($voucher->expired));
        $voucherEntity = new VoucherEntity();
        $voucherEntity->setDiscount($voucher->discount);
        $voucherEntity->setExpiredAt($expiredAt);
        $voucherEntity->setStatus($voucher->status);
        $voucherEntity->setCreatedAt($dateTime);
        $voucherEntity->setUpdatedAt($dateTime);
        return $voucherEntity;
    }

    public static function editAdapt(EditVoucher $editVoucher, VoucherEntity $voucherEntity) : VoucherEntity
    {
        $dateTime = new \DateTime();

        $expiredAt = new \DateTime('@'.strtotime($editVoucher->expired));
        $voucherEntity->setDiscount($editVoucher->discount);
        $voucherEntity->setExpiredAt($expiredAt);
        $voucherEntity->setStatus($editVoucher->status);
        $voucherEntity->setUpdatedAt($dateTime);
        return $voucherEntity;
    }

    public static function deleteAdapt(VoucherEntity $voucherEntity) : VoucherEntity
    {
        $dateTime = new \DateTime();
        $voucherEntity->setStatus(VoucherEntity::STATUS_INACTIVE);
        $voucherEntity->setUpdatedAt($dateTime);
        return $voucherEntity;
    }

}