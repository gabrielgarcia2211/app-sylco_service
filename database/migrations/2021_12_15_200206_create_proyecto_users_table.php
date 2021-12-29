<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_users', function (Blueprint $table) {
            $table->id();
            $table->integer("user_nit");
            $table->bigInteger("proyecto_id")->unsigned();
            $table->foreign('user_nit')
                ->references('nit')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto__users');
    }
}
