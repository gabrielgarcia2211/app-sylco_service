<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_users', function (Blueprint $table) {
            $table->id();
            $table->integer("user_nit");
            $table->bigInteger("file_id")->unsigned();
            $table->dateTime("date");
            $table->foreign('user_nit')
                ->references('nit')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('file_id')
                ->references('id')
                ->on('files')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file__users');
    }
}
