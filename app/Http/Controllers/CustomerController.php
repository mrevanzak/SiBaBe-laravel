<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'failed to login',
                'username or password is invalid',
                422
            );
        }

        if (! Auth::attempt($validator->validated())) {
            return $this->error(
                'failed to login',
                'username or password is invalid',
                401
            );
        }

        $customer = Customer::where('username', $request->username)->first();
        $token = $customer->createToken('auth_token')->plainTextToken;

        return $this->success(
            'login success',
            [
                'username' => $customer->username,
                'name' => $customer->name,
                'token' => $token,
            ]
        );
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:customers,username',
            'password' => 'required|string',
            'name' => 'required|string',
            'age' => 'required|integer',
            'email' => 'required|string|unique:customers,email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'failed to create user',
                $validator->errors()->first(),
                422
            );
        }

        $customer = Customer::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if (! $customer) {
            return $this->error(
                'failed to create user',
                'failed to create user',
                500
            );
        }

        return $this->success(
            'user created successfully',
            $customer,
        );
    }

    public function getUser(): JsonResponse
    {
        return $this->success(
            'Success get user',
            Auth::user(),
        );
    }
}
