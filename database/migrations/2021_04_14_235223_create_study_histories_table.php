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
            $table->unsignedBigInteger('study_id');
            $table->uuid('workbook_id');
            $table->uuid('exercise_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('score')->default(0);
            $table->primary(['study_id', 'user_id', 'workbook_id', 'exercise_id']);
            $table->timestamp('created_at', 0)->default(now())->index();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('workbook_id')
                ->references('workbook_id')
                ->on('workbooks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('exercise_id')
                ->references('exercise_id')
                ->on('exercises')
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
        Schema::dropIfExists('study_histories');
    }
}
