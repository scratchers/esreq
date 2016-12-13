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
            $table->string('course_name');
            $table->unsignedSmallInteger('faculty_accounts')->default(0);
            $table->unsignedSmallInteger('student_accounts')->default(0);
            $table->date('date_begin');
            $table->date('date_end');
            $table->boolean('IBM')->default(false);
            $table->boolean('Microsoft')->default(false);
            $table->boolean('SAP')->default(false);
            $table->boolean('SAS')->default(false);
            $table->boolean('Teradata')->default(false);
            $table->timestamp('fulfilled_at')->nullable();
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
        Schema::dropIfExists('esrequests');
    }
}
