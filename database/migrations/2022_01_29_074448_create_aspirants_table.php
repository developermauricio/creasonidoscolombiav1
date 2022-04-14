<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspirantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirants', function (Blueprint $table) {
            $table->id();
            $table->enum('has_project', [
                \App\Models\Aspirant::HAS_PROJECT,
                \App\Models\Aspirant::NOT_HAS_PROJECT,
            ])->default(\App\Models\Aspirant::NOT_HAS_PROJECT);
            $table->enum('accept_termi', [
                \App\Models\Aspirant::CUENTA_CON_CANCIONES_INEDITAS,
                \App\Models\Aspirant::ACEPTA_COMPOSITORES_CREA_SONIDOS,
            ]);
            $table->string('cc_document_pdf')->nullable();
            $table->string('cc_document_frontal')->nullable();
            $table->string('cc_document_back')->nullable();
            $table->string('extension_document')->nullable();
            $table->text('biography')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('aspirant_type_id')->nullable();
            $table->foreign('aspirant_type_id')->references('id')->on('aspirant_types');
            $table->unsignedBigInteger('ethnic_id')->nullable();
            $table->foreign('ethnic_id')->references('id')->on('ethnics');
            $table->string('head_house_hold')->nullable();
            $table->string('victim_conflict')->nullable();
            $table->string('disability')->nullable();
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
        Schema::dropIfExists('aspirants');
    }
}
