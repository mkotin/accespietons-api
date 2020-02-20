<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structures', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->string('nom',200)->nullable();
            $table->string('numero_accreditation',200)->nullable();
            $table->string('numero_agrement',200)->nullable();
            $table->string('telephone',50)->nullable();
            $table->string('email',200)->nullable();
            $table->text('siege')->nullable();
            $table->string('sigle',100)->nullable();
            $table->string('ifu',50)->nullable();
            $table->string('responsable',200)->nullable();
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
        Schema::dropIfExists('structure');
    }
}
