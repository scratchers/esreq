<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyAccountPlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_account_platforms', function (Blueprint $table) {
            $table->integer('faculty_account_id')->unsigned();
            $table->foreign('faculty_account_id')
                ->references('id')
                ->on('faculty_accounts');

            $table->integer('platform_id')->unsigned();
            $table->foreign('platform_id')
                ->references('id')
                ->on('platforms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_account_platforms');
    }
}
