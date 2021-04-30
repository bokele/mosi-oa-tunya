<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_user_id')->constrained();
            $table->foreignId('staff_id')->nullable()->constrained();
            $table->foreignId('status_id')->nullable()->constrained();
            $table->string('activity_code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->date('started_date');
            $table->date('ended_date');
            $table->time('flag')->nullable()->comment('allday,monthly,weekly,yearly');
            $table->string('support_activite_file')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
