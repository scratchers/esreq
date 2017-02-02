<?php

$pdo = require 'dev.sql-4.pdo.php';

$statement = $pdo->prepare("
    INSERT INTO [institutions] (
        [created_at]
        ,[updated_at]
        ,[name]
        ,[url]
    ) VALUES (
        GETDATE()
        ,GETDATE()
        ,:name
        ,:url
    )
");

$file = fopen(__DIR__.'/data/inst.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
    $statement->bindValue(':name', $line[0]);
    $statement->bindValue(':url',  $line[1]);
    $statement->execute();
}
fclose($file);
