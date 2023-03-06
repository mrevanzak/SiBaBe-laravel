<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all()->where('customer_username', auth()->user()->username)->sortByDesc('created_at')->values()->toArray();

        if (! $orders) {
            return $this->success('Success get history', [
                'order' => [],
            ]);
        }

        return $this->success('Success get history', [
            'order' => array_map(function ($order) {
                return [
                    'invoice' => $order['invoice'],
                    'id' => $order['id'],
                    'createdAt' => $order['created_at'],
                    'cartId' => $order['cart_id'],
                    'customerUsername' => $order['customer_username'],
                    'totalQty' => $order['total_product'],
                    'totalPrice' => $order['total_price'],
                    'status' => $order['status'],
                    'address' => $order['address'],
                    'courier' => $order['courier'],
                    'proofOfPayment' => $order['payment_proof'],
                    'validationBy' => $order['validated_by'],
                ];
            }, $orders),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::all()->where('id', $id)->first();

        if (! $order) {
            return $this->error('Failed get order', 'Failed get order', 404);
        }

        $products = ProductCart::all()->where('cart_id', $order->cart_id);

        if (! $products) {
            return $this->error('Failed get order', 'Failed get order', 404);
        }

        $products = array_map(function ($product) {
            $product_ = Product::all()->where('id', $product['product_id'])->first();

            return [
                'quantity' => $product['quantity'],
                'totalPrice' => $product['total_price'],
                'product' => $product_,
            ];
        }, $products->values()->toArray());

        return $this->success('Success get order', [
            'invoice' => $order->invoice,
            'orderId' => $order->id,
            'cartId' => $order->cart_id,
            'status' => $order->status,
            'address' => $order->address,
            'courier' => $order->courier,
            'product' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
