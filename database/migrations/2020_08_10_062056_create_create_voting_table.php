<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateVotingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_voting', function (Blueprint $table) {
            $table->id('id_voting');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_category');
            $table->string('title');
            $table->string('img');
            $table->string('description');
            $table->timestamps();
            $table->foreign('id_users')->references('id_users')->on('users_voting')->onDelete('cascade');
            $table->foreign('id_category')->references('id_category')->on('category_voting')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('create_voting');
    }
}
