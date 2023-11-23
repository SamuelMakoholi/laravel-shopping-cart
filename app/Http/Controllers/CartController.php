<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //

    public function shop()
    {
        $products = Product::all();

        return view('cart.shop', compact('products'));
    }

    public function cart()
    {
        // dd(Cart::content());
        return view('cart.cart');
    }

    public function qtyIncreament($id)
    {

        $product = Cart::get($id);
        $updatedQty = $product->qty +1;
        Cart::update($id, $updatedQty);
        return redirect()->back()->with('success', 'Product increamented successfully');
    }

    public function qtyDecreament($id)
    {

        $product = Cart::get($id);
        $updatedQty = $product->qty -1;

        if($updatedQty > 0){
            Cart::update($id, $updatedQty);
        }


        return redirect()->back()->with('success', 'Product decreamented successfully');
    }


    public function addToCart($product_id)
    {
        $product = Product::findOrFail($product_id);

        Cart::add(['id' => $product->id,
        'name' => $product->name,
        'qty' => 1,
        'price' => $product->price,
        'weight' => 0,
        'options' => ['image' => $product->image]
    ]);

    return redirect()->back()->with('success', 'Product successfully added to the Cart');
    }
}
