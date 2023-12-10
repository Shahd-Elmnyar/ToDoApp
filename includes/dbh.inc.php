<?php
$serverName = "DESKTOP-Q09JL6H\SQLEXPRESS";
$database = "toDoApp";
$DBuid = ""; 
$DBpass = ""; 

$connectionInfo = [
    "Database" => $database,
    "UID" => $DBuid,
    "PWD" => $DBpass ,
    "ReturnDatesAsStrings" => true
];

$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    echo "connect error " . print_r(sqlsrv_errors(), true);
}