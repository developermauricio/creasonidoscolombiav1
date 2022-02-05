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
            $table->string('cc_pdf')->nullable();
            $table->text('biography')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('aspirant_type_id')->nullable();
            $table->foreign('aspirant_type_id')->references('id')->on('aspirant_types');
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
