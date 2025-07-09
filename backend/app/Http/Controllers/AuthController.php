<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Đăng nhập bằng token Zalo
    public function loginWithZalo(Request $request)
    {
        $accessToken = $request->input('access_token');
        if (!$accessToken) {
            return response()->json(['error' => 'Missing Zalo access token'], 400);
        }

        // Gọi API Zalo để lấy thông tin user
        $response = Http::withHeaders([
            'access_token' => $accessToken,
        ])->get('https://graph.zalo.me/v2.0/me?fields=id,name,picture');

        if (!$response->ok()) {
            return response()->json(['error' => 'Invalid Zalo token'], 401);
        }

        $zaloUser = $response->json();
        $zaloId = $zaloUser['id'] ?? null;
        $name = $zaloUser['name'] ?? 'Zalo User';
        $avatar = $zaloUser['picture']['data']['url'] ?? null;

        if (!$zaloId) {
            return response()->json(['error' => 'Cannot get Zalo user info'], 400);
        }

        // Tìm hoặc tạo user trong DB
        $user = User::firstOrCreate(
            ['zalo_id' => $zaloId],
            [
                'name' => $name,
                'email' => $zaloId . '@zalo.me', // email giả lập
                'password' => bcrypt(Str::random(16)), // random password
                'avatar' => $avatar,
                'role' => 'user', // hoặc 'driver' nếu đăng nhập cho tài xế
            ]
        );

        // Tạo JWT token (nếu dùng tymon/jwt-auth)
        $token = auth()->login($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
        ]);
    }
}
