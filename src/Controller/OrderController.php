<?php

namespace App\Controller;

use App\Contract\PaginationRule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\IOrderService;
use App\Requests\Order\AddOrder;

/**
 * @Route("/voucher/order")
 */
class OrderController extends AbstractController
{
    protected IOrderService $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    #[Route('/add', name: 'add_order', methods: 'POST')]

    public function addOrder(AddOrder $orderInput): JsonResponse
    {
        return $this->orderService->addOrder($orderInput);
    }

    #[Route('/list', name: 'list_order', methods: 'GET')]

    public function listOrder(Request $request): JsonResponse
    {
        $requestParam = $request->query->all();
        return $this->orderService->listOrder($requestParam);
    }


}