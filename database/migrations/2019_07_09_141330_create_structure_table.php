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
            $table->string('nom',30)->nullable();
            $table->string('numero_accreditation',60)->nullable();
            $table->string('numero_agrement',60)->nullable();
            $table->string('telephone',25)->nullable();
            $table->text('siege')->nullable();
            $table->string('sigle',100)->nullable();
            $table->string('ifu',50)->nullable();
            $table->string('responsable',60)->nullable();
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
