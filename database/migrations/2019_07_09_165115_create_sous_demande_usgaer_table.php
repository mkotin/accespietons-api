<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSousDemandeUsgaerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_demandes_usagers', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('usager_id', 200)->nullable();
            $table->string('demande_id', 200)->nullable();
            $table->boolean('autorise')->nullable();
            $table->string('type_acces',20)->nullable();
            $table->string('temps_acces',20)->nullable();
            $table->string('impression_badge_id', 200)->nullable();
            $table->string('badge_type_id', 200)->nullable();
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
        Schema::dropIfExists('sous_demande_usgaer');
    }
}
