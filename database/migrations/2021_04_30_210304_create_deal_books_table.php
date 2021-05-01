<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('author')->nullable();
            $table->string('dealbook_code')->unique();
            $table->string('slug');
            $table->string('title');
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->string('video_link')->nullable();
            $table->foreignId('published_by')->constrained()->nullable();
            $table->datetime('published_at')->nullable();
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
        Schema::dropIfExists('deal_books');
    }
}
