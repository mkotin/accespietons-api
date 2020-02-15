<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id',200)->primary();
            $table->string('lname',30)->nullable();
            $table->string('fname',30)->nullable();
            $table->string('email',30)->unique();
            $table->string('login',30);
            $table->string('password',100);
            $table->string('fonction',200)->nullable();
            $table->string('role_id', 200)->nullable();
            $table->string('structure_id', 200);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('api_key', 255)->nullable();
            $table->string('remember_token',200)->nullable();
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
        Schema::dropIfExists('users');
    }
}
