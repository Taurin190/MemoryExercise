<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->primary('exercise_id');
            $table->text('question');
            $table->text('answer');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE exercises ADD FULLTEXT index content (`question`) with parser ngram');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropIfExists('content');
        });
        Schema::dropIfExists('exercises');
    }
}
