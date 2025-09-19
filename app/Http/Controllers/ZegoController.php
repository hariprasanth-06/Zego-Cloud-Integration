<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use ZEGO\ZegoErrorCodes;
use ZEGO\ZegoServerAssistant;

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

        // ✅ Correct Zego token
        $token = $this->generateZegoToken($roomId, (string)$user->id);

        return response()->json([
            'room_id' => $roomId,
            'token'   => $token,
            'app_id'  => intval(env('ZEGO_APP_ID')),
            'user_id' => $user->id,
        ]);
    }

    private function generateZegoToken(string $roomId, string $userId)
    {
        $appId       = intval(env('ZEGO_APP_ID'));
        $serverSecret = env('ZEGO_SERVER_SECRET');
        $expireTime   = 3600; // seconds

        // Privileges: 1 => login, 2 => publish stream
        $payload = json_encode([
            'room_id'   => $roomId,
            'privilege' => [1 => 1, 2 => 1],
        ]);

        $res = ZegoServerAssistant::generateToken04(
            $appId,
            $userId,
            $serverSecret,
            $expireTime,
            $payload
        );

        if ($res->code !== ZegoErrorCodes::success) {
            throw new \Exception("Zego token error: " . $res->message);
        }

        return $res->token;
    }

    public function joinMeeting($roomId)
    {
        $room = Room::where('room_id', $roomId)->firstOrFail();
        // You can also generate a token here (server-side) if needed
        $userId = 'web_' . uniqid();
        $token  = $this->generateZegoToken($roomId, $userId);

        return view('meeting', [
            'appId'  => env('ZEGO_APP_ID'),
            'roomId' => $roomId,
            'userId' => $userId,
            'token'  => $token,
        ]);
    }
}
