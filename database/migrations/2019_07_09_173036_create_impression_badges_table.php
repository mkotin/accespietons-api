<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpressionBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impression_badges', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->boolean('imprime')->nullable();
            $table->boolean('duplicata')->nullable();
            $table->string('sous_demande_usager_id', 200)->nullable();
            $table->string('reglement_duplicata_badge_id', 200)->nullable();
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
        Schema::dropIfExists('impression_badges');
    }
}
