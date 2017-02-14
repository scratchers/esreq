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
        DB::statement('ALTER TABLE users ALTER COLUMN password NVARCHAR(255) NULL;');

        // this is about the sloppiest, hackiest, worst workaround so far
        DB::statement('ALTER TABLE users ADD CONSTRAINT def_inst_uark DEFAULT(40) FOR institution_id;');

        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', array('shibboleth', 'local'))->nullable();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE users ADD CONSTRAINT def_user_type DEFAULT('local') FOR type;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users ALTER COLUMN password NVARCHAR(255) NOT NULL;');
        DB::statement('ALTER TABLE users DROP CONSTRAINT def_user_type;');
        DB::statement('ALTER TABLE users DROP CONSTRAINT def_inst_uark;');
        DB::statement('ALTER TABLE users DROP COLUMN type;');
        DB::statement('ALTER TABLE users DROP COLUMN deleted_at;');
    }
}
