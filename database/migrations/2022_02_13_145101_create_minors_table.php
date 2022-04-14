<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minors', function (Blueprint $table) {
            $table->id();
            $table->string('document_pdf')->nullable();
//            $table->string('extension_document')->nullable();
            $table->string('document_photo_frontal')->nullable();
            $table->string('document_photo_back')->nullable();
            $table->string('name');
            $table->string('last_name');
            $table->date('birthday');
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('parent_apirants');
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
        Schema::dropIfExists('minors');
    }
}
