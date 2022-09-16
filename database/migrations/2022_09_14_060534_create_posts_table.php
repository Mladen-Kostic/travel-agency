<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('post_types_id');
            $table->unsignedBigInteger('post_statuses_id');
            $table->string('post_title');
            $table->string('post_short_description');
            $table->text('post_content');
            $table->string('post_cover_img');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_types_id')->references('id')->on('post_types')->onDelete('cascade');
            $table->foreign('post_statuses_id')->references('id')->on('post_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
