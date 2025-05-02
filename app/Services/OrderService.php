<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{

    // This service class handles customer-related operations
    public function createOrders(array $data)
    {
        return Order::create([
            'product_id' => $data['product_id'],
            'user_id' => $data['customer_id'],
            'quantity' => $data['quantity'],
        ]);
    }

}
