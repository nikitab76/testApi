<?php

namespace App\Repositories\Interfaces;

interface  OrderRepositoryInterface
{
    public function create(array $data);
    public function assignWorker(int $orderId, int $workerId, float $amount): bool;
}
