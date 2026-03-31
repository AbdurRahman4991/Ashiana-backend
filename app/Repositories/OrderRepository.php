<?php

namespace App\Repositories;

use App\Models\OrderManage;
use App\Models\OrderItem;
use App\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $orderData, array $itemsData)
    {
        return \DB::transaction(function () use ($orderData, $itemsData) {
            // order_manages-এ insert
            $order = OrderManage::create($orderData);

            // order_items-এ insert
            foreach ($itemsData as &$item) {
                $item['order_id'] = $order->id;
            }
            OrderItem::insert($itemsData);

            return $order->load('orderItems');
        });
    }

     public function getUserOrders($userId)
    {
        return OrderManage::with('orderItems')
                ->where('user_id', $userId)
                ->latest()
                ->get();
    }

    public function findWithItems($id)
    {
        return OrderManage::with([
            'orderItems.product'
        ])->findOrFail($id);
    }
}