<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{

    // This service class handles customer-related operations
    public function createCustomer(array $data)
    {
        return Customer::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name']]
        );
    }

    // This method retrieves a customer by their ID
    public function updateCustomer(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }
}
