<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{

    // This service class handles customer-related operations
    public function createOrders(array $data)
    {
        return Order::create([
            'product_id' => $this->selectedProduct->id,
            'customer_id' => $customer->id,
            'quantity' => $this->quantity,
        ]);
    }

}
