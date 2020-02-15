<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpressionMacaronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impression_macarons', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->boolean('imprime')->nullable();
            $table->boolean('duplicata')->nullable();
            $table->string('reglement_duplicata_macaron_id', 200)->nullable();
            $table->string('sous_demnande_macaron_id', 200)->nullable();
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
        Schema::dropIfExists('impression_macarons_');
    }
}
