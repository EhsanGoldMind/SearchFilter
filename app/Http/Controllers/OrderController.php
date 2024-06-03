<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndexOrderResource;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrders(Request $request)
    {
        $criteria = $request->only(['status', 'customer', 'amount']);
        $orders = $this->orderService->getOrders($criteria);
        return ResponseOK(IndexOrderResource::collection($orders));
    }
}

