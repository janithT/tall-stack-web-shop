<?php

namespace App\Services;

use App\Models\User;


class CustomerService
{

    // This service class handles customer-related operations
    public function createCustomer(array $data)
    {
        // Role::firstOrCreate(['name' => 'customer']);

        $user = User::firstOrCreate(
            ['email' => $data['email']], 
            [
                'name' => $data['name'],
                'password' => bcrypt('password'), 
                // Include other required fields
            ]
        );

        // Assign role regardless of creation status
        $user->assignRole('customer');

        return $user;
    }

    // This method retrieves a customer by their ID
    public function updateCustomer(Customer $customer, array $data): Customer
    {
        $customer->update($data);
        return $customer;
    }
}
