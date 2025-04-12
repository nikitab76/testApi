<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\Worker;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function assignWorker(int $orderId, int $workerId, float $amount): bool
    {
        $order = Order::findOrFail($orderId);
        $worker = Worker::findOrFail($workerId);

        if ($worker->excludedTypes->contains($order->type_id)) {
            throw new \Exception("Worker has excluded this order type.");
        }

        $order->workers()->attach($workerId, ['amount' => $amount]);
        $order->status = 'assigned';
        $order->save();

        return true;
    }
}
