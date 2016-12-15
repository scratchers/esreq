<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esrequests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->boolean('IBM')->default(false);
            $table->boolean('Microsoft')->default(false);
            $table->boolean('SAP')->default(false);
            $table->boolean('SAS')->default(false);
            $table->boolean('Teradata')->default(false);

            $table->unsignedSmallInteger('faculty_accounts')->default(0);
            $table->unsignedSmallInteger('student_accounts')->default(0);

            $table->string('course_name')->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_end')->nullable();

            $table->timestamps();
            $table->timestamp('fulfilled_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esrequests');
    }
}
