<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tienda</h2>
            <a href="{{ route('cart') }}" class="text-indigo-600 hover:text-indigo-900">Carrito ({{ $cartQuantity ?? 0 }})</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <img class="h-48 w-full object-cover" src="{{ $product->image }}" alt="{{ $product->name }}">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-indigo-600 font-bold">${{ $product->formatted_price }}</span>
                            <a href="{{ route('product.show', $product) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ver</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-6 bg-white shadow rounded-lg">
                    <p>No hay productos disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
