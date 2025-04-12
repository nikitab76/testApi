<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignWorkerRequest;
use App\Http\Requests\FilterWorkersRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Worker;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {}

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['partnership_id'] = auth()->user()->partnership_id;

        $order = $this->service->createOrder($data);
        return response()->json($order, 201);
    }

    public function assignWorker(Order $order, AssignWorkerRequest $request)
    {
        $data = $request->validated();

        try {
            $this->service->assignWorker($order->id, $data['worker_id'], $data['amount']);
            return response()->json(['message' => 'Worker assigned']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function filterWorkers(FilterWorkersRequest $request)
    {
        $typeIds = $request->validated()['order_type_ids'];

        $workers = Worker::whereDoesntHave('excludedTypes', function ($query) use ($typeIds) {
            $query->whereIn('order_type_id', $typeIds);
        })->get();

        return response()->json($workers);
    }
}
