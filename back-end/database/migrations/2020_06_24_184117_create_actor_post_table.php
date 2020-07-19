<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_post', function (Blueprint $table) {
            $table->foreignId('actor_id');
            $table->foreignId('post_id');

            $table->foreign('actor_id')
                ->references('id')->on('actors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_post');
    }
}
