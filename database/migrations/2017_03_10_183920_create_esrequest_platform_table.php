<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsrequestPlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esrequest_platform', function (Blueprint $table) {
            $table->unsignedInteger('esrequest_id');
            $table->foreign('esrequest_id')
                ->references('id')
                ->on('esrequests')
                ->onDelete('cascade');

            $table->unsignedInteger('platform_id');
            $table->foreign('platform_id')
                ->references('id')
                ->on('platforms')
                ->onDelete('cascade');

            $table->primary(['esrequest_id', 'platform_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esrequest_platform');
    }
}
