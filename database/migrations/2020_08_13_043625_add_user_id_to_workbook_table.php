<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToWorkbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workbooks', function (Blueprint $table) {
            $table->unsignedBigInteger("author_id")->default(1);
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedTinyInteger("permission")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workbooks', function (Blueprint $table) {
            $table->dropForeign('workbooks_author_id_foreign');
            $table->dropColumn('author_id');
            $table->dropColumn('permission');
        });
    }
}
