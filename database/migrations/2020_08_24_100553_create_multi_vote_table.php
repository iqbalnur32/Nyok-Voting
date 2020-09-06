<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_vote', function (Blueprint $table) {
            $table->string('id_multi', 32)->primary();
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_category');
            $table->string('title');
            $table->string('description');
            $table->string('candidate_name1');
            $table->string('candidate_name2');
            $table->string('candidate_name3');
            $table->string('candidate_name4');
            $table->string('candidate_img1');
            $table->string('candidate_img2');
            $table->string('candidate_img3');
            $table->string('candidate_img4');
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
        Schema::dropIfExists('multi_vote');
    }
}
