<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Người đặt
            $table->unsignedBigInteger('driver_id')->nullable(); // Tài xế nhận chuyến
            $table->unsignedBigInteger('car_id')->nullable(); // Xe phục vụ
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->dateTime('pickup_time');
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled', 'driver_cancelled'])->default('pending');
            $table->integer('price')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
