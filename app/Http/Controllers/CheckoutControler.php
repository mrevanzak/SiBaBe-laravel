<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductCart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutControler extends Controller
{
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

        if (! $order) {
            return $this->error(
                'Failed checkout',
                'Failed checkout',
                400
            );
        }

        $cart->status = 'Telah checkout '.$order->invoice;
        $cart->save();

        return $this->success(
            'Success confirm checkout',
            [
                'id' => $order->id,
                'invoice' => $order->invoice,
                'username' => $order->customer_username,
                'address' => $order->address,
                'courier' => $order->courier,
                'totalPrice' => $order->total_price,
                'status' => $order->status,
            ]
        );
    }

    public function payment(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'invoice' => 'required|string',
            'proofOfPayment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation Error',
                $validator->errors()->first(),
                400
            );
        }

        $order = Order::where('invoice', $request->invoice)->first();

        if (! $order) {
            return $this->error(
                'Failed payment',
                'Failed payment',
                400
            );
        }

        $order->payment_proof = $request->proofOfPayment;
        $order->status = 'Menunggu Validasi';
        $order->save();

        return $this->success(
            'Success payment',
            $order
        );
    }
}
