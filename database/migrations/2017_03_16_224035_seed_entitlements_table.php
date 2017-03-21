<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEntitlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert("
            INSERT INTO entitlements (name) VALUES
            ('urn:mace:uark.edu:ADGroups:Walton College:Security Groups:WCOB-EnterpriseSystemsAdmins'),
            ('urn:mace:uark.edu:ADGroups:Walton College:Security Groups:WCOB-EnterpriseSystemsReporting');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
