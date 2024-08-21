<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;

class OrderController extends Controller
{
    //
    private $orderRepository;

    public function __construct(OrderRepositoryInterface  $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function create(Request $request)
    {   
        $order = $this->orderRepository->create($request->toArray());
        return response()->json([
            'code' => 0,
            'message' => 'success',
            'response' => $order
        ], 200);
    }

    public function show(Request $request)
    {   
        $order = $this->orderRepository->show($request->nro_pedido);
        return response()->json([
            'code' => 0,
            'message' => 'success',
            'response' => $order
        ], 200);
    }

    public function update(Request $request)
    {   
        $order = $this->orderRepository->update($request->toArray());
        return response()->json([
            'code' => 0,
            "message" =>'success',
            'response' => $order
        ], 200);
    }
}
