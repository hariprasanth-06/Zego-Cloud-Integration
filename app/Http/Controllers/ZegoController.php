<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class ZegoController extends Controller
{
    public function createRoom(Request $request)
    {
        $user = $request->user();
        $roomId = 'room_' . time();

        $room = Room::create([
            'room_id' => $roomId,
            'name' => "Room at {$request->latitude},{$request->longitude}",
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_by' => $user->id,
        ]);

        // Generate Zego token
        $token = $this->generateZegoToken($roomId, $user->id);

        return response()->json([
            'room_id' => $roomId,
            'token' => $token,
            'app_id' => env('ZEGO_APP_ID'),
            'user_id' => $user->id,
        ]);
    }

    private function generateZegoToken($roomId, $userId)
    {
        $appId = env('ZEGO_APP_ID');
        $serverSecret = env('ZEGO_SERVER_SECRET');

        $expireTime = 3600;

        $payload = [
            "app_id" => $appId,
            "user_id" => (string)$userId,
            "room_id" => $roomId,
            "exp" => time() + $expireTime
        ];

        return JWT::encode($payload, $serverSecret, 'HS256');
    }
}
