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
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
        
            // Create or find customer
            $customer = $customerService->createCustomer([
                'name' => $validated['customerName'],
                'email' => $validated['customerEmail'],
            ]);
        
            // Create the order
            $order = $orderService->createOrders([
                'product_id' => $this->selectedProduct->id,
                'customer_id' => $customer->id,
                'quantity' => $this->quantity,
            ]);
        
            // Optional: Reduce product stock here if implemented
            // $this->selectedProduct->decrement('stock', $this->quantity);
        
            DB::commit();
        
            session()->flash('message', 'Order placed successfully!');
            $this->reset(['selectedProduct', 'customerName', 'customerEmail', 'quantity']);
        
        } catch (\Throwable $th) {
            DB::rollBack();
        
            session()->flash('error', 'Failed to place order.');
            Log::error('Order placement error: ' . $th->getMessage());
        
            // Optional: Show detailed error while debugging
            // throw $th;
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