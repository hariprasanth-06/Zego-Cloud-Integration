<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public static function successMessage($message)
    {
        return response()->json(
            [
                'status' => true,
                'message'  => $message
            ],
            200
        );
    }
    public static function errorMessage($message)
    {

        return response()->json(
            [
                'status' => false,
                'message'  => $message
            ],
            200
        );
    }
    public static function successData($data)
    {
        return response()->json(
            [
                'status' => true,
                'data'  => $data,
                'message' => 'success',
            ],
            200
        );
    }
    public static function successDataWithMessage($data, $message)
    {
        return response()->json(
            [
                'status' => true,
                'message' => $message,
                'data'  => $data,
            ],
            200
        );
    }
    public static function crudCondition($condition, $message)
    {
        if ($condition) {
            return Controller::successMessage($message);
        } else {
            return Controller::errorMessage('Some Error Occured.');
        }
    }

    public static function OTPCheck($mode, $message)
    {

        return response()->json(
            [
                'status' => true,
                'mode'  => $mode,
                'message' => $message
            ],
            200
        );
    }
    public static function registerMessage($condition, $isRegister, $message)
    {
        if ($condition) {
            return response()->json(
                [
                    'status' => true,
                    'register'  => $isRegister,
                    'message' => $message
                ],
                200
            );
        } else {
            return Controller::errorMessage('Some Error Occured.');
        }
    }
}
