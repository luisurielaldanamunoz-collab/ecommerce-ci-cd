<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('name')->get();
        $cart = session('cart', []);
        $cartQuantity = array_sum(array_column($cart, 'quantity'));

        return view('shop.index', compact('products', 'cartQuantity'));
    }

    public function show(Product $product): View
    {
        $cart = session('cart', []);
        $cartQuantity = array_sum(array_column($cart, 'quantity'));

        return view('shop.show', compact('product', 'cartQuantity'));
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', "{$product->name} agregado al carrito.");
    }

    public function cart(): View
    {
        $cart = session('cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('shop.cart', ['cart' => $cart, 'total' => $total]);
    }

    public function removeFromCart(Product $product): RedirectResponse
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart')->with('success', "{$product->name} eliminado del carrito.");
    }
}
