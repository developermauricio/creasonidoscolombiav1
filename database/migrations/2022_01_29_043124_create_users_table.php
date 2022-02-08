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
            $table->string('document')->nullable();
            $table->string('name');
            $table->string('last_name');
            $table->string('user_name')->nullable();;
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();;
            $table->string('slug')->nullable();
            $table->string('picture')->nullable();;
            $table->string('password');
            $table->date('birthday')->nullable();;
            $table->enum('state', [1, 2])->default(1)->nullable();;
            $table->string('address')->nullable();;
            $table->unsignedBigInteger('document_type_id')->nullable();;
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('url_facebook')->nullable();;
            $table->string('url_youtube')->nullable();;
            $table->string('url_instagram')->nullable();;
            $table->string('url_tiktok')->nullable();;
            $table->string('url_snapchat')->nullable();;
            $table->string('url_spotify')->nullable();;
            $table->string('url_apple_music')->nullable();;
            $table->string('url_deezer')->nullable();;
            $table->string('web_site')->nullable();;
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
