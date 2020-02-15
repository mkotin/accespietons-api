<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->string('id',200)->primary();
            $table->date('date_retrait')->nullable();
            $table->date('date_soumission')->nullable();
            $table->integer('statut')->nullable();
            $table->integer('niveau_acces')->nullable();
            $table->integer('montant')->nullable();
            $table->string('responsable',50)->nullable();
            $table->string('objet_demande',200)->nullable();
            $table->integer('montant_accepte')->nullable();
            $table->string('structure_id',200)->nullable();
            $table->string('reglement_demande_id', 200)->nullable();
            $table->string('seance_cos_id', 200)->nullable();
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
        Schema::dropIfExists('demandes');
    }
}
