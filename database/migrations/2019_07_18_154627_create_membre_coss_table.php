<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembreCossTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membre_coss', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('matricule',30)->unique()->nullable();
            $table->string('nom',30)->nullable();
            $table->string('prenoms',25)->nullable();
            $table->string('fonction',30)->nullable();
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
        Schema::dropIfExists('membre_coss');
    }
}
