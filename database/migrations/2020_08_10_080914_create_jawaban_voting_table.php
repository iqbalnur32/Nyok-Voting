<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanVotingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_voting', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_voting');
            $table->unsignedBigInteger('id_users');
            $table->string('nama_lengkap');
            $table->enum('jawaban', ['setuju', 'tidak_setuju']);
            $table->string('description');
            $table->timestamps();
            $table->foreign('id_voting')->references('id_voting')->on('create_voting')->onDelete('cascade');
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
        Schema::dropIfExists('jawaban_voting');
    }
}
