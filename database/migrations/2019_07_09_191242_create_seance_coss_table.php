<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeanceCossTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seance_coss', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('numero_seance',25)->nullable();
            $table->datetime('date_debut')->nullable();
            $table->datetime('date_fin')->nullable();
            $table->integer('statut')->nullable();
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
        Schema::dropIfExists('seance_coss');
    }
}
