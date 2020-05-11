<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_histories', function (Blueprint $table) {
            $table->bigIncrements('answer_history_id');
            $table->string('answer');
            $table->float('score');
            $table->uuid('workbook_id');
            $table->uuid('exercise_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('workbook_id')
                ->references('workbook_id')
                ->on('workbooks')
                ->onDelete('cascade');
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
        Schema::dropIfExists('answer_histories');
    }
}
