<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Feedback_Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->reviews = Feedback::all()->where('product_id', $product->id);

            foreach ($product->reviews as $review) {
                $review->username = Feedback_Order::all()->where('feedback_id', $review->id)->first()->username;
            }
        }

        return $this->success(
            'Succes get all products',
            $products,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'price' => 'required|integer',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Failed to create product',
                $validator->errors()->first(),
                400
            );
        }

        $product = Product::create($validator->validated());

        if (! $product) {
            return $this->error(
                'Failed to create product',
                'Failed to create product',
                500
            );
        }

        return $this->success(
            'Success create product',
            $product
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Failed to update product',
                $validator->errors()->first(),
                400
            );
        }

        $product = Product::findOrFail($id);

        if (! $product->update($validator->validated())) {
            return $this->error(
                'Failed to update product',
                'Failed to update product',
                500
            );
        }

        return $this->success(
            'Success update product',
            $product
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Failed to delete product',
                $validator->errors()->first(),
                400
            );
        }

        $product = Product::findOrFail($id);

        if (! $product->delete()) {
            return $this->error(
                'Failed to delete product',
                'Failed to delete product',
                500
            );
        }

        return $this->success(
            'Success delete product',
            null
        );
    }
}
