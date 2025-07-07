<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

/**
 * @OA
tag="Booking"
 * @OA\Info(
 *     title="CarBooking API",
 *     version="1.0.0"
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Lấy danh sách booking",
     *     tags={"Booking"},
     *     @OA\Response(response=200, description="Danh sách booking")
     * )
     */
    // Hiển thị danh sách booking
    public function index()
    {
        return Booking::all();
    }
}
