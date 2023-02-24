<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __invokebale()
    {
        Admin::firstOrCreate([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name' => 'admin',
            'email' => 'admin@sibabe.app',
            'phone' => '08123456789',
        ]);
    }

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

          if (! auth('admins')->attempt($validator->validated())) {
              return $this->error(
                  'failed to login',
                  'username or password is invalid',
                  401
              );
          }

          $admin = Admin::where('username', $request->username)->first();
          $token = $admin->createToken('auth_token')->plainTextToken;

          return $this->success(
              'login success',
              [
                  'username' => $admin->username,
                  'name' => $admin->name,
                  'token' => $token,
              ]
          );
      }
}
