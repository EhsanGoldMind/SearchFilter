<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
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

    public function getOrders(SearchRequest $request)
    {
        $orders = $this->orderService->getOrders($request->validated());
        return ResponseOK(IndexOrderResource::collection($orders));
    }
}

