<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_label', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->unsignedBigInteger('label_id');
            $table->primary(['exercise_id', 'label_id']);

            $table->foreign('exercise_id')
                ->references('exercise_id')
                ->on('exercises')
                ->onDelete('cascade');

            $table->foreign('label_id')
                ->references('label_id')
                ->on('labels')
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
        Schema::dropIfExists('exercise_label');
    }
}
