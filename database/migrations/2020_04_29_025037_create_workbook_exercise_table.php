<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkbookExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workbook_exercise', function (Blueprint $table) {
            $table->uuid('workbook_id');
            $table->uuid('exercise_id');
            $table->primary(['workbook_id', 'exercise_id']);

            $table->foreign('workbook_id')
                ->references('workbook_id')
                ->on('workbooks')
                ->onDelete('cascade');
            $table->foreign('exercise_id')
                ->references('exercise_id')
                ->on('exercises')
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
        Schema::dropIfExists('workbook_exercise');
    }
}
