<?php

namespace App\Adapter;

use App\Entity\Order as OrderEntity;
use App\Requests\Order\AddOrder;

class OrderAdapter
{
    public static function adapt(AddOrder $order) : OrderEntity
    {
        $dateTime = new \DateTime();
        $orderEntity = new OrderEntity();
        $orderEntity->setTotalAmount($order->price);
        $orderEntity->setCreatedAt($dateTime);
        return $orderEntity;
    }

}