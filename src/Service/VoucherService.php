<?php

namespace App\Service;

use App\Adapter\VoucherAdaptor;
use App\Exception\ConflictException;
use App\Exception\NotAcceptableException;
use App\Exception\NotFoundException;
use App\Helper\Abstract\AbstractCodeGenerator;
use App\Repository\VoucherRepository;
use App\Requests\Voucher\AddVoucher;
use App\Service\Interface\IVoucherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Message\Message;
use App\Entity\Voucher as VoucherEntity;
use App\Response\ResponseBuilder;
use App\Requests\Voucher\EditVoucher;

class VoucherService extends AbstractCodeGenerator implements IVoucherService
{
    private VoucherRepository $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * @param AddVoucher $voucherInput
     * @return JsonResponse
     */
    public function addVoucher(AddVoucher $voucherInput): JsonResponse
    {
        $voucher =  VoucherAdaptor::adapt(voucher: $voucherInput);
        $voucher->setCode($this->getUniqueCode());
        $this->voucherRepository->save($voucher, true);
        return ResponseBuilder::created($this->buildVoucherResponse($voucher));
    }

    /**
     * @param int $id
     * @param EditVoucher $editVoucher
     * @return JsonResponse
     */
    public function editVoucher(int $id,EditVoucher $editVoucher): JsonResponse
    {
        $voucher = $this->findVoucherById(id: $id);
        $this->findVoucherByStatusId(id:$id, status:[VoucherEntity::STATUS_EXPIRED, VoucherEntity::STATUS_USED], checkEmpty:false);
        $voucher =  VoucherAdaptor::editAdapt(editVoucher: $editVoucher,  voucherEntity:$voucher);
        $this->voucherRepository->save($voucher, true);
        return ResponseBuilder::ok('', $this->buildVoucherResponse($voucher) );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteVoucher(int $id): JsonResponse
    {
        $voucher = $this->findVoucherById($id);
        $voucher = VoucherAdaptor::deleteAdapt(voucherEntity: $voucher);
        $this->voucherRepository->save($voucher, true);
        return ResponseBuilder::noContent();
    }

    /**
     * @param int $status
     * @return JsonResponse
     */
    public function listVoucher(int $status): JsonResponse
    {
        $vouchers = $this->findVoucherListByStatus($status);
        return ResponseBuilder::Ok('', array_map('self::buildVoucherResponse', $vouchers));
    }

    /**
     * @param VoucherEntity $user
     * @return array
     */
    private function buildVoucherResponse(VoucherEntity $voucher): array
    {
        return [
            'id' => $voucher->getId(),
            'code' => $voucher->getCode(),
            'discount' => $voucher->getDiscount(),
            'expiredAt' => $voucher->getExpiredAt()
        ];
    }

    /**
     * @param string $code
     * @return VoucherEntity
     */
    public function findVoucherByCode(string $code): VoucherEntity
    {
        $voucher = $this->voucherRepository->findVoucherByCode($code);
        if(empty($voucher)) {
            throw new NotFoundException(Message::VOUCHER_NOT_FOUND);
        }
        return $voucher;
    }

    /**
     * @param int $id
     * @param array $status
     * @param $checkEmpty
     * @return array
     */
    public function findVoucherByStatusId(int $id = 0, array $status = [], $checkEmpty = true): array
    {
        $voucher = $this->voucherRepository->findVoucherByStatusId($id, $status);
        $voucherCondition = ($checkEmpty) ? empty($voucher): !empty($voucher);
        if($voucherCondition) {
            throw new NotAcceptableException(Message::VOUCHER_EDIT_NOT_ALLOWED);
        }
        return $voucher;
    }

    /**
     * @param int $id
     * @param int $status
     * @return void
     */
    public function updateVoucherStatus(int $id, int $status): void
    {
        $this->voucherRepository->updateVoucherStatus(id:$id, status: $status);
    }

    public function getUniqueCode()
    {
        while($this->maxRetries >= 0) {
            $voucherCode = $this->generateCode();
            if($this->voucherRepository->findVoucherByCode($voucherCode) == null) {
                return $voucherCode;
            }
            $this->maxRetries --;
        }
        throw new ConflictException(Message::VOUCHER_CODE_CONFLICT);
    }
    /**
     * @param int $id
     * @return VoucherEntity
     */
    private function findVoucherById(int $id): VoucherEntity
    {
        $voucher = $this->voucherRepository->findVoucherById($id);
        if(empty($voucher)) {
            throw new NotFoundException(Message::VOUCHER_NOT_FOUND);
        }
        return $voucher;
    }

    /**
     * @param int $status
     * @return array
     */
    private function findVoucherListByStatus(int $status): array
    {
        $vouchers = [];
        switch ($status) {
            CASE VoucherEntity::STATUS_ACTIVE:
                $vouchers = $this->voucherRepository->findVoucherListByStatus(VoucherEntity::STATUS_ACTIVE, '>');
                BREAK;
            CASE VoucherEntity::STATUS_USED:
                $vouchers =  $this->voucherRepository->findVoucherListByStatus(VoucherEntity::STATUS_USED);
                BREAK;
            CASE VoucherEntity::STATUS_EXPIRED:
                $vouchers = $this->voucherRepository->findVoucherListByStatus(VoucherEntity::STATUS_EXPIRED, '<');
        }
        if(empty($vouchers)) {
            throw new NotFoundException(Message::VOUCHER_NOT_FOUND);
        }
        return $vouchers;
    }



}