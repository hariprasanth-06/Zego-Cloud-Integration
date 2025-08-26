<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|string',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Controller::errorMessage($validator->getMessageBag()->first());
        }

         if (!$token = auth('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return Controller::errorMessage("Kindly check your credentials");
        }


        return $this->getData($token, auth('api')->user());
    }

     public function getData($token, $user)
    {
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'user' => $user,
        ]);
    }
}
