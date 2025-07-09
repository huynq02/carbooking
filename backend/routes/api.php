
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\ZaloPKCEHelper;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


use App\Http\Controllers\AuthController;

// API đăng nhập bằng Zalo (callback nhận code từ Zalo)
Route::get('/login/zalo', [AuthController::class, 'zaloCallback']);

// Nếu bạn muốn nhận access_token từ frontend gửi lên thì dùng POST
Route::post('/login/zalo', [AuthController::class, 'loginWithZalo']);




// Route sinh code_verifier và code_challenge, lưu code_verifier vào storage
Route::get('/zalo/gen-pkce', function () {
    $codeVerifier = ZaloPKCEHelper::generateCodeVerifier();
    $codeChallenge = ZaloPKCEHelper::generateCodeChallenge($codeVerifier);

    Storage::disk('local')->put('oauth/zalo_code_verifier.txt', $codeVerifier);

    return [
        'code_verifier' => $codeVerifier,
        'code_challenge' => $codeChallenge,
    ];
});
