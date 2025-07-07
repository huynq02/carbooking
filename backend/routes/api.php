<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\BookingController;

// CRUD booking
Route::get('/bookings', [BookingController::class, 'index']); // Danh sách
Route::post('/bookings', [BookingController::class, 'store']); // Tạo mới
Route::get('/bookings/{id}', [BookingController::class, 'show']); // Xem chi tiết
Route::put('/bookings/{id}', [BookingController::class, 'update']); // Cập nhật
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']); // Xóa
