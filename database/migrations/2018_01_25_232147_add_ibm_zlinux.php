<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Platform;

class AddIbmZlinux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ibm = Platform::where('name', 'IBM')->get()->first();
        $ibm->name = 'IBM-TSO';
        $ibm->save();

        Platform::create(['name' => 'IBM-zLinux']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $ibm = Platform::where('name', 'IBM-TSO')->get()->first();
        $ibm->name = 'IBM';
        $ibm->save();

        Platform::where('name', 'IBM-zLinux')->get()->first()->delete();
    }
}
