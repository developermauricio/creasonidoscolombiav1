<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyects', function (Blueprint $table) {
            $table->id();
            $table->string('tittle');
            $table->string('description');
            $table->enum('status', [
                \App\Models\Proyect::BORRADOR,
                \App\Models\Proyect::REVISION,
                \App\Models\Proyect::ACEPTED,
                \App\Models\Proyect::REJECTED,
                \App\Models\Proyect::APPROVAL,
                \App\Models\Proyect::PENDING_REGISTER,
            ]);
            $table->string('audio');
            $table->string('slug');
            $table->integer('end_time');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');
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
        Schema::dropIfExists('proyects');
    }
}
