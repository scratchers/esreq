-- set platform name on line 5, id on line 13

BEGIN TRY
    BEGIN TRANSACTION
        DECLARE db_cursor CURSOR FOR SELECT id FROM esrequests WHERE Teradata = 1;
        DECLARE @eid INT;

        OPEN db_cursor;
        FETCH NEXT FROM db_cursor INTO @eid;
        WHILE @@FETCH_STATUS = 0
        BEGIN
            INSERT INTO esrequest_platform (esrequest_id, platform_id)
            VALUES (@eid, 8);

            FETCH NEXT FROM db_cursor INTO @eid;
        END;
        CLOSE db_cursor;
        DEALLOCATE db_cursor;
    COMMIT
END TRY

BEGIN CATCH
    ROLLBACK;
    THROW
END CATCH
