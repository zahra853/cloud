<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show cart page
     */
    public function index(Request $request)
    {
        $cart = session('cart', []);
        
        // Apply voucher if provided in query
        if ($request->has('voucher')) {
            session(['voucher_code' => $request->voucher]);
            // TODO: Validate and calculate discount
        }
        
        return view('user.cart.index', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, Barang $barang)
    {
        $cart = session('cart', []);
        
        $id = $barang->id;
        
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'name' => $barang->nama,
                'price' => $barang->harga,
                'qty' => 1,
                'image' => $barang->gambar,
                'stock' => $barang->stok
            ];
        }
        
        session(['cart' => $cart]);
        
        return back()->with('success', $barang->nama . ' added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$id])) {
            if ($request->action === 'increase') {
                $cart[$id]['qty']++;
            } elseif ($request->action === 'decrease') {
                $cart[$id]['qty']--;
                if ($cart[$id]['qty'] <= 0) {
                    unset($cart[$id]);
                }
            }
            session(['cart' => $cart]);
        }
        
        return back();
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        
        return back()->with('success', 'Item removed from cart');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget(['cart', 'voucher_code', 'discount']);
        return back()->with('success', 'Cart cleared');
    }
}
