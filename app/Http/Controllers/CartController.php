<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function createCart()
    {
        $customer = auth()->user()->username;

        $cart = new Cart();
        $cart->username = $customer;
        $cart->status = 'Belum Checkout';
        $cart->total_price = 0;
        $cart->save();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $message = 'Success get cart'): JsonResponse
    {
        $carts = Cart::all()->where('username', auth()->user()->username)->where('status', 'Belum Checkout')->first();

        if (! $carts) {
            $this->createCart();
            $carts = Cart::where('username', auth()->user()->username)
                ->where('status', 'Belum Checkout')->first();
        }

        $productCart = ProductCart::where('cart_id', $carts->id)->orderBy('product_id', 'asc')->get();
        $products = [];
        $totalQty = 0;

        foreach ($productCart as $product) {
            array_push($products, [
                'cartId' => $product->cart_id,
                'productId' => $product->product_id,
                'quantity' => $product->quantity,
                'totalPrice' => $product->total_price,
                'product' => Product::all()->where('id', $product->product_id)->first(),
            ]);
            $totalQty += $product->quantity;
        }

        return $this->success(
            $message,
            [
                'id' => $carts->id,
                'username' => $carts->username,
                'totalQty' => $totalQty,
                'totalPrice' => $carts->total_price,
                'product' => $products,
            ]
        );
    }

    public function addToCart(int $id): JsonResponse
    {
        $products = Product::all()->where('id', $id)->first();

        if (! $products) {
            return $this->error(
                'Product not found',
                'Product not found',
                400
            );
        }
        $cart = Cart::where('username', auth()->user()->username)
            ->where('status', 'Belum Checkout')->first();

        if (! $cart) {
            $this->createCart();
            $cart = Cart::where('username', auth()->user()->username)
                ->where('status', 'Belum Checkout')->first();
        }

        $productCart = ProductCart::where('product_id', $id)->where('cart_id', $cart->id)->first();

        if (! $productCart) {
            $productCart = ProductCart::create([
                'product_id' => $id,
                'cart_id' => $cart->id,
                'total_price' => $products->price,
            ]);
        } else {
            $productCart->quantity += 1;
            $productCart->total_price += $products->price;
            $productCart->save();
        }

        $cart->total_price += $products->price;
        $cart->save();

        return $this->success(
            'Succes add to cart',
            [
                'cartId' => $productCart->cart_id,
                'productId' => $productCart->product_id,
                'quantity' => $productCart->quantity,
                'totalPrice' => $productCart->total_price,
            ]
        );
    }

    public function addQuantity(int $id): JsonResponse
    {
        $productCart = ProductCart::all()->where('product_id', $id)->first();
        $product = Product::all()->where('id', $productCart->product_id)->first();

        if (! $productCart) {
            return $this->error(
                'Product not found',
                'Product not found',
                400
            );
        }

        $productCart->quantity += 1;
        $productCart->total_price += $product->price;
        $productCart->save();

        $cart = Cart::all()->where('id', $productCart->cart_id)->first();
        $cart->total_price += $product->price;
        $cart->save();

        return $this->index('Success update cart');
    }

    public function minusQuantity(int $id): JsonResponse
    {
        $productCart = ProductCart::all()->where('product_id', $id)->first();
        $product = Product::all()->where('id', $productCart->product_id)->first();

        if (! $productCart) {
            return $this->error(
                'Product not found',
                'Product not found',
                400
            );
        }

        $productCart->quantity -= 1;
        $productCart->total_price -= $product->price;
        $productCart->save();

        if ($productCart->quantity == 0) {
            $productCart->delete();
        }

        $cart = Cart::all()->where('id', $productCart->cart_id)->first();
        $cart->total_price -= $product->price;
        $cart->save();

        return $this->index('Success update cart');
    }

    public function checkoutConfirm(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'courier' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation Error',
                $validator->errors()->first(),
                400
            );
        }

        $cart = Cart::where('username', auth()->user()->username)
            ->where('status', 'Belum Checkout')->first();
        $productCart = ProductCart::where('cart_id', $cart->id)->get();

        $order = Order::create([
            'customer_username' => auth()->user()->username,
            'cart_id' => $cart->id,
            'address' => $request->address,
            'courier' => $request->courier,
            'total_price' => $cart->total_price,
            'status' => 'Belum Dibayar',
            'total_product' => count($productCart),
        ]);

        return $this->success(
            'Success checkout',
            [
                'id' => $order->id,
                'username' => $order->customer_username,
                'address' => $order->address,
                'courier' => $order->courier,
                'totalPrice' => $order->total_price,
                'status' => $order->status,
            ]
        );
    }
}
