<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Handle account registration request
     */
    public function register(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'fullname'      => 'required',
            'username'     => 'required|unique:customers',
            'password'  => 'required|min:6'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $customer = Customer::create([
            'fullname'      => $request->fullname,
            'username'     => $request->username,
            'password'  => Hash::make($request->password)
        ]);

        //return response JSON user is created
        if($customer) {
            return response()->json([
                'success' => true,
                'customer'    => $customer,
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $customer = Customer::where('username', '=',$request["username"])->first();
        if (!$customer){
            return response()->json([
                'success' => false,
                'message'    => "Username does not exists",
            ], 401);
        }

        $verifyPassword = Hash::check($request["password"], $customer["password"]);
        if(!$verifyPassword){
            return response()->json([
                'success' => false,
                'message' => "Password does not match",
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'customer'   => $customer,
        ], 200);
    }
}
