<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inviter', function (Blueprint $table) {
            $table->string('id', 200)->primary();
            $table->boolean('participe_cos')->nullable();
            $table->boolean('participe_structure')->nullable();
            $table->string('seance_cos_id', 200)->nullable();
            $table->string('membre_cos_id', 200)->nullable();
            $table->string('structure_id', 200)->nullable();
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
        Schema::dropIfExists('inviter');
    }
}
