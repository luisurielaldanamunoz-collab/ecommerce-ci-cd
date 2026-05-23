<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->name }}</h2>
            <a href="{{ route('cart') }}" class="text-indigo-600 hover:text-indigo-900">Carrito ({{ $cartQuantity ?? 0 }})</a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
        <img class="w-full h-64 object-cover rounded" src="{{ $product->image }}" alt="{{ $product->name }}">

        <div class="mt-4">
            <p class="text-2xl font-bold">${{ $product->formatted_price }}</p>
            <p class="mt-2 text-gray-700">{{ $product->description }}</p>
            <p class="mt-2 text-sm text-gray-500">Inventario: {{ $product->inventory }}</p>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4 flex gap-2 items-center">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->inventory }}" class="border rounded px-2 py-1 w-20" />
                <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Agregar al carrito</button>
            </form>
        </div>
    </div>
</x-app-layout>
