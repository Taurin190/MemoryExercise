<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('study_history_id');
            $table->uuid('workbook_id');
            $table->uuid('exercise_id');
            $table->unsignedInteger('score')->default(0);
            $table->primary(['study_history_id', 'workbook_id', 'exercise_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_histories');
    }
}
