<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLongToInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // break this up into two statements for SQLite
        // https://stackoverflow.com/a/6172889/4233593
        Schema::table('institutions', function (Blueprint $table) {
            $table->decimal('latitude', 8, 6)->nullable();
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->decimal('longitude', 9, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('latitude');
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('longitude');
        });
    }
}
