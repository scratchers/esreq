<?php

$institutions = [
    '15' => '1',
    '42' => '2',
    '14' => '3',
    '37' => '4',
    '21' => '5',
    '51' => '6',
    '26' => '7',
    '19' => '8',
    '30' => '9',
    '33' => '10',
    '20' => '11',
    '28' => '12',
    '47' => '13',
    '17' => '14',
    '45' => '15',
    '39' => '16',
    '27' => '17',
    '50' => '18',
    '36' => '19',
    '23' => '20',
    '40' => '21',
    '32' => '22',
    '34' => '23',
    '46' => '24',
    '22' => '25',
    '29' => '26',
    '54' => '27',
    '25' => '28',
    '52' => '29',
    '44' => '30',
    '18' => '31',
    '43' => '32',
    '59' => '33',
    '49' => '34',
    '38' => '35',
    '35' => '36',
    '16' => '37',
    '41' => '38',
    '53' => '39',
    '48' => '40',
    '31' => '41',
];

$pdo = require 'dev.pdo.php';

$file = fopen(__DIR__.'/data/users.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {

    $statement = $pdo->prepare("
        INSERT INTO [users] (
            [institution_id]
            ,[first_name]
            ,[last_name]
            ,[email]
            ,[password]
            ,[created_at]
            ,[updated_at]
        ) VALUES (
            :institution_id
            ,:first_name
            ,:last_name
            ,:email
            ,'password'
            ,GETDATE()
            ,GETDATE()
        )
    ");

    $statement->bindValue(':email',          $line[1]);
    $statement->bindValue(':first_name',     $line[2]);
    $statement->bindValue(':last_name',      $line[3]);
    $statement->bindValue(':institution_id', $institutions[$line[4]], PDO::PARAM_INT);
    $statement->execute();
}
fclose($file);
