<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuradorProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curador_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curador_id');
            $table->foreign('curador_id')->references('id')->on('curadors');
            $table->unsignedBigInteger('proyect_id');
            $table->foreign('proyect_id')->references('id')->on('proyects');
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
        Schema::dropIfExists('curador_projects');
    }
}
