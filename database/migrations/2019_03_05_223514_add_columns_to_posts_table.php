<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->bigInteger('discussion_id')->unsigned()->default(0);
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('discussion_id')->references('id')->on('discussions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
}
