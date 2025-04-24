<?php

namespace App\Livewire\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrderFormValidator
{
    public static function validate($data)
    {
        $rules = [
            'customerName' => ['required', 'string', 'min:2'],
            'customerEmail' => ['required', 'email', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];

        $messages = [
            'customerName.required' => 'Please enter your name.',
            'customerName.min' => 'Your name must be at least 2 characters.',
            'customerEmail.required' => 'We need your email to proceed.',
            'customerEmail.email' => 'Please provide a valid email address.',
            'quantity.required' => 'Please enter a quantity.',
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'You must order at least 1 item.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
