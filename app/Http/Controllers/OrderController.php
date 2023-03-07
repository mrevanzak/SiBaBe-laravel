<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at')->values()->toArray();

        if (! $orders) {
            return $this->success('Success get history', []);
        }

        $data = array_map(function ($order) {
            $user = Customer::all()->where('username', $order['customer_username'])->first();

            $productCart = ProductCart::where('cart_id', $order['cart_id'])->orderBy('product_id', 'asc')->get()->values()->toArray();

            $product = array_map(function ($product) {
                return [
                    'cartId' => $product['cart_id'],
                    'productId' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'totalPrice' => $product['total_price'],
                    'product' => Product::all()->where('id', $product['product_id'])->first(),
                ];
            }, $productCart);

            // query to google maps search for address
            $address = $order['address'];
            $address = str_replace(' ', '+', $address);
            $url = "https://google.com/maps/search/$address";

            return [
                'invoice' => $order['invoice'],
                'orderId' => $order['id'],
                'cartId' => $order['cart_id'],
                'customer' => $order['customer_username'],
                'phone' => $user->phone,
                'address' => $url,
                'finalPrice' => $order['total_price'],
                'status' => $order['status'],
                'orderList' => $product,
            ];
        }, $orders);

        return $this->success('Success get history', $data);
    }

    public function confirm(string $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation error', $validator->errors()->first(), 422);
        }

        $order = Order::all()->where('id', $id)->first();

        if (! $order) {
            return $this->error('Order not found', 'Order not found', 404);
        }

        $order->status = $request->status;
        $order->validated_by = auth()->user()->username;
        $order->save();

        return $this->success('Success confirm order', $order);
    }
}
