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
            $table->string('title');
            $table->text('description');
            $table->string('name_author');
            $table->enum('state', [
                \App\Models\Proyect::BORRADOR,
                \App\Models\Proyect::REVISION,
                \App\Models\Proyect::ACEPTED,
                \App\Models\Proyect::QUALIFIED,
                \App\Models\Proyect::REJECTED,
                \App\Models\Proyect::APPROVAL,
                \App\Models\Proyect::PENDING_REGISTER,
            ])->default(\App\Models\Proyect::BORRADOR);
            $table->string('audio');
            $table->string('slug');
            $table->timestamp('end_time')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
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
