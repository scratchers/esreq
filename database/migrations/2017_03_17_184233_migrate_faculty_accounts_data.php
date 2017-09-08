<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateFacultyAccountsData extends Migration
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

        DB::insert('
            INSERT INTO [faculty_accounts]
                ( [user_id], [username], [password] )
            SELECT u.[id], o.[username], o.[password]
            FROM [users] u
            JOIN [EnterpriseSystemsUsers] o
              ON u.[email] = o.[email]
        ');

        $platform_id = 0;

        $platforms = [
            'isIAI' => 'IAI',
            'isMEC' => 'MEC',
            'isSAP' => 'SAP',
            'isTUN' => 'TUN',
        ];

        foreach ( $platforms as $platform => $value ) {
            // this *depends* on 2017_03_10_174501_seed_platforms_table.php
            $platform_id++;

            DB::statement("
                BEGIN TRY
                    BEGIN TRANSACTION
                        DECLARE db_cursor CURSOR FOR
                            SELECT id
                            FROM faculty_accounts f
                            JOIN EnterpriseSystemsUsers e
                              ON f.username = e.username
                            WHERE e.$platform = '$value';
                        DECLARE @eid INT;

                        OPEN db_cursor;
                        FETCH NEXT FROM db_cursor INTO @eid;
                        WHILE @@FETCH_STATUS = 0
                        BEGIN
                            INSERT INTO faculty_account_platform (faculty_account_id, platform_id)
                            VALUES (@eid, $platform_id);

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

        DB::insert('
            INSERT INTO [faculty_accounts] ([username],[password])
            SELECT [username],[password]
            FROM [EnterpriseSystemsUsers]
            WHERE [email] IS NULL AND [firstname] IS NULL
        ');
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
