<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('assigned_staff_id')->nullable()->constrained();
            $table->foreignId('activity_id')->nullable()->constrained();
            $table->foreignId('status_id')->nullable()->constrained();
            $table->string('booking_code')->unique();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->longText('user_comment')->nullable();
            $table->longText('staff_comment')->nullable();
            $table->longText('admin_comment')->nullable();
            $table->enum('come_into_office', ['yes', 'no']);
            $table->string('user_support_file')->nullable();
            $table->string('staff_support_file')->nullable();
            $table->string('admin_support_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
}
