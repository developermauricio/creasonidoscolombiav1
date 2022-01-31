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
            $table->string('document');
            $table->string('name');
            $table->string('last_name');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('slug');
            $table->string('picture');
            $table->string('password');
            $table->date('birthday');
            $table->string('url_facebook');
            $table->string('url_youtube');
            $table->string('url_instagram');
            $table->string('url_tiktok');
            $table->string('url_snapchat');
            $table->string('url_spotify');
            $table->string('url_apple_music');
            $table->string('url_deezer');
            $table->string('web_site');
            $table->enum('state', [1, 2]);
            $table->string('address');
            $table->unsignedBigInteger('document_type_id');
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->unsignedBigInteger('gender_id');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
