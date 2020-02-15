<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usagers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nom',30)->nullable();
            $table->string('prenoms',30)->nullable();
            $table->date('date_naiss')->nullable();
            $table->string('lieu_naiss',30)->nullable();
            $table->string('nationalite',40);
            $table->text('photo')->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone',30)->nullable();
            $table->string('email',30)->nullable()->unique();
            $table->string('fonction',100)->nullable();
            $table->string('num_piece_identite',50)->unique();
            $table->string('num_carte_professionelle',50)->nullable();
            $table->string('num_certificat_prise_service',50)->nullable();
            $table->boolean('actif')->default(false);
            $table->datetime('date_ajout')->nullable();
            $table->string('statut',10)->nullable();
            $table->string('structure_id',200)->nullable();
            $table->string('badge_id',200)->nullable();
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
        Schema::dropIfExists('usager');
    }
}
