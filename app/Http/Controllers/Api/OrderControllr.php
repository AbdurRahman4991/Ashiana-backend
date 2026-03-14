<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderControllr extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * নতুন order place করা
     */
    public function placeOrder(Request $request)
    {
        $request->validate([          
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.selling_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); 
        $order = $this->orderService->placeOrder($userId, $request->items);

        return response()->json([
            'message' => 'Order successfully placed',
            'data' => $order
        ], 201);
    }

    public function myOrders(Request $request)
    {
        $userId = auth()->id();

        $orders = $this->orderService->myOrders($userId);

        return response()->json([
            "status" => true,
            "data" => $orders
        ]);
    }
}
