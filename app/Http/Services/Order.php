<?php

namespace App\Http\Services;

use App\Models\Bun;
use App\Models\Crew;
use App\Models\Filling;
use App\Models\Order as ModelsOrder;
use App\Models\OrderFilling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class Order
{

    private array $errors = [];

    private Bun $bun;
    private array $fillings = [];
    private int $price;
    private ModelsOrder $order;

    public function __construct(private Crew $crewMember, $orderId = null)
    {
        if ($orderId) {
            $this->order = ModelsOrder::where('pkId', $orderId)->first();
            if (is_null($this->order)) {
                throw new Exception("Order not found");
            }
        } else {
            $this->order = new ModelsOrder(['crewId' => $crewMember['pkId']]);
        }
    }

    public function create(Request $request)
    {
        $this->validateInput($request);
        if (!empty($this->errors)) {
            throw new Exception("Error with given input");
        }
        $this->calculatePrice();
        $this->saveOrder();
        $this->populateFillings();

        Log::info("Order Create : {$this->order}");
    }

    public function update(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            switch ($key) {
                case 'bun':
                    $this->validateBun($value);
                    break;
                case 'filling':
                    $this->validatefillings($value);
                    break;
                default:
                    $this->errors[] = 'unknown burger component {$key}';
            }
            if (!empty($this->errors)) {
                throw new Exception("Error with given input");
            }

            $this->calculatePrice();
            $this->saveOrder();
            $this->populateFillings();
        }
    }

    public function delete()
    {
        OrderFilling::where('OrderId', $this->order['pkId'])->delete();
        $this->order->delete();
    }

    /**
     * function to validate input for order additions and updates
     * $this->errors for detailed errors
     * 
     * @param Request $request
     * @returns void
     * 
     */
    private function validateInput(Request $request): void
    {
        $keys = array_keys($request->all());
        foreach ($keys as $key) {
            if (!in_array($key, ['bun', 'filling'])) {
                $this->errors[] = "Unkown input {$key}";
            }
        }
        $bun = $request->input('bun');
        $fillings = $request->input('filling');

        $this->validateBun($bun);
        $this->validatefillings($fillings);
    }

    private function calculatePrice(): void
    {
        if (!isset($this->bun)) {
            $this->getOrderBun();
        }
        $price = $this->bun['price'];

        if (empty($this->fillings)) {
            $this->getOrderFillings();
        }
        foreach ($this->fillings as $filling) {
            $price += $filling['price'];
        }

        $this->order['price'] =  $price;
    }

    private function saveOrder()
    {
        $this->order->save();
    }

    private function populateFillings()
    {
        $orderId = $this->order['pkId'];

        //remove any existing fillings
        OrderFilling::where('orderId', $orderId)->delete();

        foreach ($this->fillings as $filling) {
            $orderFilling = new OrderFilling([
                'orderId' => $orderId,
                'fillingId' => $filling['pkId']
            ]);

            $orderFilling->save();
        }
    }

    private function validateBun($bun)
    {
        if (is_null($bun)) {
            $this->errors[] = "input error : Bun selection is missing";
        }

        $bun = Bun::where('description', $bun)->first();

        if (is_null($bun)) {
            $this->errors[] = "Bun not found {$bun}";
        } else {
            $this->bun = $bun;
            $this->order['bunId'] = $this->bun['pkId'];
        }
    }
    private function validatefillings($fillings)
    {

        if (is_null($fillings)) {
            $this->errors[] = "input error : filling selection is missing";
        }
        $fillings = explode(',', $fillings);

        foreach ($fillings as $filling) {
            $filling = trim($filling);
            $availableFilling = Filling::where('description', $filling)->first();
            if (is_null($availableFilling)) {
                $this->errors[] = "Filling not found {$filling}";
                continue;
            }
            $this->fillings[] = $availableFilling;
        }
    }

    private function getOrderBun(): void
    {
        $this->bun = $this->order->bun()->first();
    }

    private function getOrderFillings(): void
    {
        $this->fillings = $this->order->fillings()->get()->toArray();
    }



    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getOrderId(): int
    {
        return $this->order['pkId'];
    }
    public function getPrice(): int
    {
        return $this->order['price'];
    }
}
