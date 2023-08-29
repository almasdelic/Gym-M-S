<?php

session_start();

$servername = "localhost";
$db_username = "root";
$password = 1234;
$database_name = "gym";

$conn = mysqli_connect($servername, $db_username, $password, $database_name);

if(!$conn) {
    die ("Neuspješna konekcija");
}