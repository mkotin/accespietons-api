<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('marque',30)->nullable();
            $table->string('matricule',25)->unique()->nullable();
            $table->string('num_carte_grise',25)->unique()->nullable();
            $table->string('type',30)->nullable();
            $table->string('structure_id', 200)->nullable();
            $table->string('macaron_id', 200)->nullable();
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
        Schema::dropIfExists('vehicules');
    }
}
