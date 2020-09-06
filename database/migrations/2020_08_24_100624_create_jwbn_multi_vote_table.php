<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJwbnMultiVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jwbn_multi_vote', function (Blueprint $table) {
            $table->id('id_jwbn_multi');
            $table->string('id_multi');
            $table->unsignedBigInteger('id_users');
            $table->string('point');
            $table->timestamps();
            $table->foreign('id_multi')->references('id_multi')->on('multi_vote')->onDelete('cascade');
            $table->foreign('id_users')->references('id_users')->on('users_voting')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jwbn_multi_vote');
    }
}
