<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkbookHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workbook_histories', function (Blueprint $table) {
            $table->bigIncrements('workbook_history_id');
            $table->integer('exercise_count');
            $table->integer('ok_count');
            $table->integer('ng_count');
            $table->integer('studying_count');
            $table->uuid('workbook_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('workbook_id')
                ->references('workbook_id')
                ->on('workbooks')
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
        Schema::dropIfExists('workbook_histories');
    }
}
