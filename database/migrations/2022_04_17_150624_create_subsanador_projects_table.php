<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsanadorProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsanador_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subsanador_id');
            $table->foreign('subsanador_id')->references('id')->on('subsanadors');
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
        Schema::dropIfExists('subsanador_projects');
    }
}
