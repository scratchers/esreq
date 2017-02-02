<?php

$users = [
    '31' => '1',
    '32' => '2',
    '33' => '3',
    '34' => '4',
    '35' => '5',
    '36' => '6',
    '37' => '7',
    '38' => '8',
    '39' => '9',
    '40' => '10',
    '42' => '11',
    '43' => '12',
    '44' => '13',
    '45' => '14',
    '46' => '15',
    '47' => '16',
    '48' => '17',
    '49' => '18',
    '50' => '19',
    '51' => '20',
    '52' => '21',
    '53' => '22',
    '54' => '23',
    '55' => '24',
    '56' => '25',
    '57' => '26',
    '58' => '27',
    '59' => '28',
    '60' => '29',
    '61' => '30',
    '62' => '31',
    '63' => '32',
    '64' => '33',
    '65' => '34',
    '66' => '35',
    '67' => '36',
    '68' => '37',
    '69' => '38',
    '70' => '39',
    '71' => '40',
    '72' => '41',
    '73' => '42',
    '74' => '43',
    '75' => '44',
    '78' => '45',
];

$pdo = require 'dev.pdo.php';

$file = fopen(__DIR__.'/data/reqs.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {

    $statement = $pdo->prepare("
        INSERT INTO [esrequests] (
            [user_id]
            ,[IBM]
            ,[Microsoft]
            ,[SAP]
            ,[SAS]
            ,[Teradata]
            ,[faculty_accounts]
            ,[student_accounts]
            ,[created_at]
            ,[updated_at]
            ,[fulfilled_at]
        ) VALUES (
             :user_id
            ,:IBM
            ,:Microsoft
            ,:SAP
            ,:SAS
            ,:Teradata
            ,:faculty_accounts
            ,:student_accounts
            ,:created_at
            ,:updated_at
            ,:fulfilled_at
        )
    ");

    $statement->bindValue(':user_id',      $users[$line[0]], PDO::PARAM_INT);
    $statement->bindValue(':created_at',   $line[1]);
    $statement->bindValue(':updated_at',   $line[1]);
    $statement->bindValue(':fulfilled_at', $line[1]);

    if ( $line[2] === '1' ) {
        $statement->bindValue(':faculty_accounts', $line[2], PDO::PARAM_INT);
        $statement->bindValue(':student_accounts', 0, PDO::PARAM_INT);
    } else {
        $statement->bindValue(':faculty_accounts', 0, PDO::PARAM_INT);
        $statement->bindValue(':student_accounts', $line[2], PDO::PARAM_INT);
    }

    $statement->bindValue(':SAP',       $line[3], PDO::PARAM_INT);
    $statement->bindValue(':SAS',       $line[4], PDO::PARAM_INT);
    $statement->bindValue(':Teradata',  $line[5], PDO::PARAM_INT);
    $statement->bindValue(':Microsoft', $line[6], PDO::PARAM_INT);
    $statement->bindValue(':IBM',       $line[7], PDO::PARAM_INT);

    $statement->execute();
}
fclose($file);
