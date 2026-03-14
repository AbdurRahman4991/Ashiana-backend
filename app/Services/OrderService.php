<?php

namespace App\Services;

use App\Interfaces\OrderRepositoryInterface;
use PDF;

class OrderService
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function placeOrder($userId, $items)
    {
        $total = 0;
        $formattedItems = [];

        foreach ($items as $item) {
            $discountedPrice = $item['selling_price'] * (1 - $item['discount_percent'] / 100);
            $total += $discountedPrice * $item['qty'];

            $formattedItems[] = [
                'product_id' => $item['product_id'],
                'selling_price' => $item['selling_price'],
                'discount_percent' => $item['discount_percent'],
                'discounted_price' => $discountedPrice,
                'qty' => $item['qty'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $orderData = [
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pending'
        ];

        return $this->orderRepo->createOrder($orderData, $formattedItems);
    }

    public function myOrders($userId)
    {
        return $this->orderRepo->getUserOrders($userId);
    }

     public function getOrderDetails($id)
    {
        return $this->orderRepo->findWithItems($id);
    }

    public function generateInvoice($id)
    {

        $order = $this->orderRepo->findWithItems($id);

        $pdf = PDF::loadView('invoice.invoice', [
            'order' => $order
        ]);

        return $pdf->download("invoice-{$order->id}.pdf");
    }
}