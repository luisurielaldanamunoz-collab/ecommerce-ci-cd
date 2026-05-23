<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900">Continuar comprando</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if (count($cart) === 0)
            <div class="p-6 bg-white shadow rounded text-center">
                <p>Tu carrito está vacío.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded">Ir a tienda</a>
            </div>
        @else
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Producto</th>
                            <th class="p-3 text-left">Precio</th>
                            <th class="p-3 text-left">Cantidad</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item['name'] }}</td>
                                <td class="p-3">${{ number_format($item['price'] / 100, 2) }}</td>
                                <td class="p-3">{{ $item['quantity'] }}</td>
                                <td class="p-3">${{ number_format($item['price'] * $item['quantity'] / 100, 2) }}</td>
                                <td class="p-3">
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 text-right">
                    <p class="text-xl font-semibold">Total: ${{ number_format($total / 100, 2) }}</p>
                    <button class="mt-3 px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">Finalizar compra</button>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
