<?php

use Illuminate\Database\Migrations\Migration;

class MigrateEsrequestPlatformData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (App::environment() === 'testing') {
            return;
        }

        // this *depends* on 2017_03_10_174501_seed_platforms_table.php
        $platforms = [
            1 => 'IBM',
            2 => 'Microsoft',
            3 => 'SAP',
            4 => 'Teradata',
        ];

        foreach ( $platforms as $id => $platform ) {
            DB::statement("
                BEGIN TRY
                    BEGIN TRANSACTION
                        DECLARE db_cursor CURSOR FOR
                            SELECT id FROM esrequests WHERE $platform = 1;
                        DECLARE @eid INT;

                        OPEN db_cursor;
                        FETCH NEXT FROM db_cursor INTO @eid;
                        WHILE @@FETCH_STATUS = 0
                        BEGIN
                            INSERT INTO esrequest_platform (esrequest_id, platform_id)
                            VALUES (@eid, $id);

                            FETCH NEXT FROM db_cursor INTO @eid;
                        END;
                        CLOSE db_cursor;
                        DEALLOCATE db_cursor;
                    COMMIT
                END TRY

                BEGIN CATCH
                    ROLLBACK;
                    THROW;
                END CATCH
            ");
        }
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
