<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // khách đặt xe
            $table->unsignedBigInteger('driver_id')->nullable(); // tài xế nhận chuyến
            $table->unsignedBigInteger('car_id')->nullable(); // xe được chọn
            $table->string('pickup_location'); // điểm đón
            $table->string('dropoff_location'); // điểm đến
            $table->dateTime('pickup_time'); // thời gian đón
            $table->string('status'); // trạng thái chuyến (pending, accepted, completed, cancelled...)
            $table->decimal('price', 12, 2)->nullable(); // giá chuyến đi
            $table->text('note')->nullable(); // ghi chú thêm
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
