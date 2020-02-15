<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->string('id',200)->primary();
            $table->string('code_badge',100)->unique()->nullable();
            $table->datetime('debut_validite')->nullable();
            $table->datetime('fin_validite')->nullable();
            $table->string('temps_acces',15)->nullable();
            $table->string('type_acces',15)->nullable();
            $table->date('date_expiration')->nullable();
            $table->boolean('actif')->nullable();
            $table->integer('compteur_impression')->nullable();
            $table->string('qr_code')->unique()->nullable();
            $table->datetime('date_impression')->nullable();
            $table->string('imprime_par',50)->nullable();
            $table->string('usager_id',200)->nullable();
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
        Schema::dropIfExists('badges');
    }
}
