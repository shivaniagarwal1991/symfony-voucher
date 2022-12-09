<?php

namespace App\Service;

use App\Exception\NotAcceptableException;
use App\Repository\OrderRepository;
use App\Requests\Order\AddOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\IOrderService;
use App\Adapter\OrderAdapter;
use App\Message\Message;
use App\Entity\Order as OrderEntity;
use App\Response\ResponseBuilder;
use App\Service\Interface\IVoucherService;
use App\Entity\Voucher as VoucherEntity;
use App\Contract\PaginationRule;

class OrderService implements IOrderService
{
    private OrderRepository $orderRepository;

    private IVoucherService $voucherService;

    public function __construct(OrderRepository $orderRepository, IVoucherService $voucherService)
    {
        $this->orderRepository = $orderRepository;
        $this->voucherService = $voucherService;
    }

    /**
     * @param AddOrder $orderInput
     * @return JsonResponse
     */
    public function addOrder(AddOrder $orderInput): JsonResponse
    {
        $voucher = $this->getVoucherDiscount($orderInput);

        $order =  OrderAdapter::adapt($orderInput);
        $order->setPaidAmount($orderInput->price - $voucher->getDiscount());
        $order->setVoucherId($voucher->getId());
        $this->orderRepository->save($order, true);
        return ResponseBuilder::created($this->buildOrderResponse($order));

    }

    /**
     * @param array $requestParam
     * @return JsonResponse
     */
    public function listOrder(array $requestParam): JsonResponse
    {
        $page = $this->getPageSizeAndOffset($requestParam);
        $orders = $this->orderRepository->getOrders($page['offset'], $page['pageSize']);
        return ResponseBuilder::Ok('', array_map('self::buildOrderResponse', $orders));
    }

    /**
     * @param array $requestParam
     * @return array
     */
    private function getPageSizeAndOffset(array $requestParam) : array
    {
        $pageNo = (!empty($requestParam['page_no'])) ? $requestParam['page_no'] : PaginationRule::PAGE_NO;
        $pageSize = (!empty($requestParam['page_size'])) ? $requestParam['page_size'] : PaginationRule::PAGE_SIZE;
        $offset =  ($pageNo == PaginationRule::PAGE_NO) ? $pageNo-1 : ($pageNo-1) * $pageSize + 1;
        return ['pageSize' => $pageSize, 'offset' => $offset ];
    }

    /**
     * @param VoucherEntity $user
     * @return array
     */
    private function buildOrderResponse(OrderEntity $order): array
    {
        return [
            'id' => $order->getId(),
            'totalAmount' => $order->getTotalAmount(),
            'voucherId' => $order->getVoucherId(),
            'paidAmount' => $order->getPaidAmount(),
            'createdAt' => $order->getCreatedAt()
        ];
    }

    /**
     * @param AddOrder $orderInput
     * @return VoucherEntity|null
     */
    private function getVoucherDiscount(AddOrder $orderInput): ?VoucherEntity
    {
        if(!empty($orderInput->voucherCode)) {
            $voucher = $this->voucherService->findVoucherByCode($orderInput->voucherCode);
            try {
                $voucher = $this->voucherService->findVoucherByStatusId($voucher->getId(), status:[VoucherEntity::STATUS_ACTIVE])[0];
            } catch(NotAcceptableException $e) {
                throw new NotAcceptableException(Message::VOUCHER_USED);
            }

            if($voucher->getDiscount() > $orderInput->price) {
                throw new NotAcceptableException(Message::VOUCHER_AMOUNT_MORE_THAN_PRICE);
            }

            if($voucher->getExpiredAt() < date('Y-m-d')) {
                throw new NotAcceptableException(Message::VOUCHER_EXPIRED);
            }
            $this->voucherService->updateVoucherStatus($voucher->getId(), VoucherEntity::STATUS_USED);

            return $voucher;
        }

    }
}