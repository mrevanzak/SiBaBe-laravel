<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->success(
            'success get all product',
            Product::all(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::where('id', $id)->first();

        if (! $product) {
            return $this->error(
                'failed to get product by id',
                'product not found',
                404
            );
        }

        $feedback = Feedback::where('id_produk', $id)->get();

        if (! $feedback) {
            return $this->error(
                '',
                'feedback not found',
                404
            );
        }

        return $this->success(
            $product,
            'success get product'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return Product::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::findOrFail($id)->delete();
    }
}
