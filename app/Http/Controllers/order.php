<?php

namespace App\Http\Controllers;

use App\Http\Services\Order as OrderService;
use App\Models\Bun;
use App\Models\Crew;
use App\Models\Filling;
use App\Models\Order as ModelsOrder;
use App\Models\OrderFilling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Order extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate input
        $requested = json_encode($request->all());
        Log::info("Order Recieved : {$requested}");
        try {
            $orderService = new OrderService($request->attributes->get('crewMember'));
        } catch (Exception $e) {
            $result = [
                'message' => $e->getMessage(),
            ];
            return response(json_encode($result), 400)
                ->header('Content-Type', 'text/json');
        }
        try {
            $orderService->create($request);
        } catch (Exception $e) {
            $result = [
                'message' => $e->getMessage(),
                'errors' => $orderService->getErrors(),
            ];
            return response(json_encode($result), 400)
                ->header('Content-Type', 'text/json');
        }

        $result = [
            'message' => 'OrderAccepted',
            'orderId' => $orderService->getOrderId(),
            'price' => $orderService->getPrice()
        ];
        return response(json_encode($result), 200)
            ->header('Content-Type', 'text/json');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $orderService = new OrderService($request->attributes->get('crewMember'), $id);
        } catch (Exception $e) {
            $result = [
                'message' => $e->getMessage(),
            ];
            return response(json_encode($result), 400)
                ->header('Content-Type', 'text/json');
        }
        try {
            $orderService->Update($request);
        } catch (Exception $e) {
            $result = [
                'message' => $e->getMessage(),
                'errors' => $orderService->getErrors(),
            ];
            return response(json_encode($result), 400)
                ->header('Content-Type', 'text/json');
        }

        $result = [
            'message' => 'Order Updated',
            'orderId' => $orderService->getOrderId(),
            'price' => $orderService->getPrice()
        ];
        return response(json_encode($result), 200)
            ->header('Content-Type', 'text/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $orderService = new OrderService($request->attributes->get('crewMember'), $id);
        } catch (Exception $e) {
            $result = [
                'message' => $e->getMessage(),
            ];
            return response(json_encode($result), 400)
                ->header('Content-Type', 'text/json');
        }

        $orderService->delete();
        $result = [
            'message' => 'Order Deleted'
        ];
        return response(json_encode($result), 200)
            ->header('Content-Type', 'text/json');
    }
}
