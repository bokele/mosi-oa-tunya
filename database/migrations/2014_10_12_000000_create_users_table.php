<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_code')->nullable()->unique();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_superuser')->default(false);
            $table->boolean('is_investor')->default(false);
            $table->boolean('is_candidate')->default(false);
            $table->boolean('is_entrepreneur')->default(false);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->boolean('active_status')->default(0);
            $table->boolean('dark_mode')->default(0);
            $table->string('messenger_color')->default('#2180f3');
            $table->dateTime('last_login_time')->nullable();
            $table->dateTime('last_logout_time')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->macAddress('last_login_device')->nullable();
            $table->text('last_login_agent')->nullable();
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
        Schema::dropIfExists('users');
    }
}
