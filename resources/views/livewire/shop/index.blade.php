<div class="container mx-auto px-4 py-6">
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)" 
            class="mb-4 p-4 bg-green-100 text-green-800 rounded"
        >
            {{ session('message') }}
        </div>
    @endif
    <div class="flex flex-col md:flex-row md:space-x-4 mb-6">
        <!-- Filters Sidebar -->
        <div class="md:w-1/4 space-y-4">
            <!-- Category Filter -->
            <div>
                <h2 class="font-semibold text-lg mb-2">Categories</h2>
                <button wire:click="$set('selectedCategory', null)"
                        class="block text-left w-full px-3 py-1 rounded hover:bg-gray-200 {{ is_null($selectedCategory) ? 'bg-gray-300' : '' }}">
                        All
                </button>
                @foreach($categories as $cat)
                    <button wire:click="$set('selectedCategory', {{ $cat->id }})"
                        class="block text-left w-full px-3 py-1 rounded hover:bg-gray-200 {{ $selectedCategory === $cat->id ? 'bg-gray-300' : '' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <!-- Sort Options -->
            <div>
                <h2 class="font-semibold text-lg mb-2">Sort by</h2>
                <select wire:model="sortBy" class="w-full px-3 py-2 border rounded">
                    <option value="name">Name (A-Z)</option>
                    <option value="price">Price (Low to High)</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <h2 class="font-semibold text-lg mb-2">Search</h2>
                <input type="text" wire:model.debounce.500ms="search" placeholder="Search products..."
                    class="w-full px-3 py-2 border rounded">
            </div>
        </div>

        <!-- Product Grid -->
        <div class="md:w-3/4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="border rounded p-4 flex flex-col justify-between shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                    <p class="text-gray-700 mt-2">${{ number_format($product->price, 2) }}</p>
                    <button wire:click="selectProduct({{ $product->id }})"
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        Order
                    </button>
                </div>
            @empty
                <p class="text-gray-600">No products found.</p>
            @endforelse
        </div>
    </div>

    @if($selectedProduct)
        <div class="mt-8 border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Order: {{ $selectedProduct->name }}</h2>

            <form wire:submit.prevent="placeOrder" class="space-y-4 max-w-lg">
                <div>
                    <label class="block mb-1">Your Name</label>
                    <input type="text" wire:model="customerName" class="w-full px-4 py-2 border rounded" required>
                    @error('customerName') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">Email</label>
                    <input type="email" wire:model="customerEmail" class="w-full px-4 py-2 border rounded" required>
                    @error('customerEmail') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">Quantity</label>
                    <input type="number" wire:model="quantity" class="w-full px-4 py-2 border rounded" min="1" required>
                    @error('quantity') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Place Order
                </button>
            </form>
        </div>
    @endif
</div>
