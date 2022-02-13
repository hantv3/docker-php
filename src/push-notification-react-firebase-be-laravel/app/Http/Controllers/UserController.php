<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Add device token for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDeviceToken(Request $request)
    {
        $user = getUsers($request->bearerToken());
        //getUser($request->bearerToken()) là mình đang sử dụng JWT nên mình chỉ lấy ra user với user_id truyển nên mà thôi 
        return response()->json([
            $user->update(['device_key' => $request->device_token])
        ], 200);
    }
    /**
     * handle push notification
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotification(Request $request)
    {
        $deviceToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        $dataEndCode = json_encode([
            "registration_ids" => $deviceToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ]);

        $headerRequest = [
            'Authorization: key=' . env('FIRE_BASE_FCM_KEY'),
            'Content-Type: application/json'
        ];
        // FIRE_BASE_FCM_KEY mình có note ở phần 2.setting firebase nhé

        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('FIRE_BASE_URL'));
        //FIRE_BASE_URL = https://fcm.googleapis.com/fcm/send 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataEndCode);
        // Mục đích mình đưa các tham số kia vào env để tùy biến nhé
        $output = curl_exec($ch);
        if ($output === FALSE) {
            log('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        return response()->json($output);
    }
}