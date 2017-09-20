<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPlatformColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['IBM', 'Microsoft', 'SAP', 'SAS', 'Teradata'] as $platform) {
            if (config('database.default') === 'sqlsrv') {
                // TSQL drop generated default constraints
                // https://stackoverflow.com/a/8641990/4233593
                DB::statement("
                    DECLARE @sql NVARCHAR(MAX)
                    WHILE 1=1
                    BEGIN
                        SELECT TOP 1 @sql = N'alter table esrequests drop constraint ['+dc.NAME+N']'
                        FROM sys.default_constraints dc
                        JOIN sys.columns c
                            ON c.default_object_id = dc.object_id
                        WHERE
                            dc.parent_object_id = OBJECT_ID('esrequests')
                        AND c.name = N'$platform'
                        IF @@ROWCOUNT = 0 BREAK
                        EXEC (@sql)
                    END
                ");
            }

            // can only drop one column at a time per SQLite
            Schema::table('esrequests', function (Blueprint $table) use ($platform) {
                $table->dropColumn($platform);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('esrequests', function (Blueprint $table) {
            //
        });
    }
}
