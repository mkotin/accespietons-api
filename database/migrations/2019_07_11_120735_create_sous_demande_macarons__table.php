<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSousDemandeMacaronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_demande_macarons_', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('vehicule_id')->nullable();
            $table->string('demande_id')->nullable();
            $table->boolean('autorise')->nullable();
            $table->string('type_acces',25)->nullable();
            $table->string('temps_acces',25)->nullable();
            $table->string('macaron_type_id', 200)->nullable();
            $table->string('impression_macaron_id', 200)->nullable();
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
        Schema::dropIfExists('sous_demande_macarons_');
    }
}
