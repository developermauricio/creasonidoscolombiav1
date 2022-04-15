<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_projects', function (Blueprint $table) {
            $table->id();
            $table->string('interpretive_quality');
            $table->string('quality_proposal');
            $table->string('composition_quality');
            $table->string('song_potential');
            $table->string('territorial_value');
            $table->text('comment');
            $table->unsignedBigInteger('curadores_id');
            $table
                ->foreign('curadores_id')
                ->references('id')
                ->on('curadors');
            $table->unsignedBigInteger('proyect_id');
            $table
                ->foreign('proyect_id')
                ->references('id')
                ->on('proyects');
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
        Schema::dropIfExists('qualification_projects');
    }
}
