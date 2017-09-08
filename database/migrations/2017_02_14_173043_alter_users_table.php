<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // this is about the sloppiest, hackiest, worst workaround so far
        // DB::statement('ALTER TABLE users ADD CONSTRAINT def_inst_uark DEFAULT(40) FOR institution_id;');

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('institution_id')->unsigned()->default(40)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (App::environment() === 'testing') {
            return;
        }

        DB::statement('ALTER TABLE users DROP CONSTRAINT def_inst_uark;');
        DB::statement('ALTER TABLE users DROP COLUMN deleted_at;');
    }
}
