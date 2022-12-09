<?php

namespace App\Service\Interface;

use App\Requests\Order\AddOrder;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IOrderService
{
    /**
     * @param AddOrder $orderInput
     * @return JsonResponse
     */
    public function addOrder(AddOrder $orderInput): JsonResponse;

    /**
     * @param array $requestParam
     * @return JsonResponse
     */
    public function listOrder(array $requestParam): JsonResponse;

}