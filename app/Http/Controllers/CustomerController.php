<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username', 'password');

        $customer = Customer::where('username', $credentials['username'])->first();

        if (! $customer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->successWithData($customer);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'name' => 'required|string',
            'age' => 'required|integer',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $customer = Customer::create([
            'username' => $request->username,
            'password' => $request->password,
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if (! $customer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->successWithData($customer);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();

        return $this->successWithData($user);
    }
}
