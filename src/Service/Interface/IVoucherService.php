<?php

namespace App\Service\Interface;


use App\Requests\Voucher\AddVoucher;
use App\Requests\Voucher\EditVoucher;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Voucher as VoucherEntity;

interface IVoucherService
{
    public function addVoucher(AddVoucher $voucherInput): JsonResponse;

    public function editVoucher(int $id,EditVoucher $editVoucher): JsonResponse;

    public function deleteVoucher(int $id): JsonResponse;

    public function listVoucher(int $status): JsonResponse;

    public function findVoucherByCode(string $code): VoucherEntity;

    public function findVoucherByStatusId(int $id = 0, array $status = [], $checkEmpty = true): array;

    public function updateVoucherStatus(int $id, int $status): void;

}