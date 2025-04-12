<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(protected OrderRepositoryInterface $repository) {}

    public function createOrder(array $data)
    {
        return $this->repository->create($data);
    }

    public function assignWorker(int $orderId, int $workerId, float $amount)
    {
        return $this->repository->assignWorker($orderId, $workerId, $amount);
    }
}
