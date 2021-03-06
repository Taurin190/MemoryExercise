<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_histories', function (Blueprint $table) {
            $table->bigIncrements('exercise_history_id');
            $table->integer('score');
            $table->uuid('exercise_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('exercise_id')
                ->references('exercise_id')
                ->on('exercises')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_histories');
    }
}
