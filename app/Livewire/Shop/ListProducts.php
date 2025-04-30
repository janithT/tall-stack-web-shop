<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use App\Livewire\Validators\OrderFormValidator;
use App\Services\CustomerService;
use App\Services\OrderService;

class ListProducts extends Component
{
    public $search = '';
    public $sortBy = 'name';
    public $selectedCategory = null;
    public $selectedProduct = null;

    public $customerName;
    public $customerEmail;
    public $quantity = 1;


    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
    }

    public function updatedSortBy($value)
    {
        Log::info('Sort by updated: ' . $value);
        $this->sortBy = $value;
    }

    // Place order method
    public function placeOrder(CustomerService $customerService, OrderService $orderService)
    {
        $validated = OrderFormValidator::validate([
            'customerName' => $this->customerName,
            'customerEmail' => $this->customerEmail,
            'quantity' => $this->quantity,
        ]);

        try {
            /* 
            Create or update the customer from customer model
            or use service class to create customer.
            */

            $customer = $customerService->createCustomer([
                'name' => $validated['customerName'],
                'email' => $validated['customerEmail'],
            ]);

            // Create order with relationships- same as above
            $order = $orderService->createOrders([
                'product_id' => $this->selectedProduct->id,
                'customer_id' => $customer->id,
                'quantity' => $this->quantity,
            ]);

            // Reduce product stock - not available in this example
            // $this->selectedProduct->stock -= $this->quantity;
            // $this->selectedProduct->save();
        
            if ($order) {
                session()->flash('message', 'Order placed successfully!');
                $this->reset(['selectedProduct', 'customerName', 'customerEmail', 'quantity']);
            }
            
            session()->flash('message', 'Order placed successfully!');
            $this->reset(['customerName', 'customerEmail', 'quantity', 'selectedProduct']);

        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', $th->getMessage());
            Log::error('Error placing order: ' . $th->getMessage());
        }
        
    }

    // Reset selected product
    public function render()
    {

        $products = Product::query()
            ->when($this->selectedCategory, fn($q) => $q->whereHas('categories', fn($q) => $q->where('categories.id', $this->selectedCategory)))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy($this->sortBy)
            ->get();

        return view('livewire.shop.index', [
            'products' => $products ?? [],
            'categories' => Category::all() ?? [],
        ]);
    }

}