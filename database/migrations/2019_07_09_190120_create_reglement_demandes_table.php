<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReglementDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reglement_demandes', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('code',25)->nullable();
            $table->datetime('date_reglement')->nullable();
            $table->boolean('regle')->nullable();
            $table->string('numero_recu',25)->nullable();
            $table->boolean('recu_utilise')->nullable();
            $table->string('bordereau',25)->nullable();
            $table->string('demande_id',200)->nullable();
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
        Schema::dropIfExists('reglement_demandes');
    }
}
