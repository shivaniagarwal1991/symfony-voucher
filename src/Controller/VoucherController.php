<?php

namespace App\Controller;

use App\Requests\Voucher\EditVoucher;
use App\Service\Interface\IVoucherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Requests\Voucher\AddVoucher;

/**
 * @Route("/voucher")
 */
class VoucherController extends AbstractController
{
    protected IVoucherService $voucherService;

    public function __construct(IVoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    #[Route('/add', name: 'add_voucher', methods: 'POST')]

    public function addVoucher(AddVoucher $voucherInput): JsonResponse
    {
        return $this->voucherService->addVoucher($voucherInput);
    }

    #[Route('/update/{id}', name: 'edit_voucher', methods: 'PUT')]

    public function editVoucher(EditVoucher $voucher, int $id): JsonResponse
    {
        return $this->voucherService->editVoucher($id, $voucher);
    }

    #[Route('/{id}', name: 'delete_voucher', methods: 'DELETE')]

    public function deleteVoucher(int $id): JsonResponse
    {
        return $this->voucherService->deleteVoucher($id);
    }

    #[Route('/list/{statusCode}', name: 'list_voucher_by_status', methods: 'GET')]

    public function getVoucherByStatus(int $statusCode): JsonResponse
    {
        return $this->voucherService->listVoucher($statusCode);
    }
}