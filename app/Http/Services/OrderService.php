<?php

namespace App\Http\Services;


use App\Http\repository\RepositoryInterface\OrderRepositoryInterface;

class OrderService {
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders(array $criteria) {
        return $this->orderRepository->filter($criteria);
    }
}


