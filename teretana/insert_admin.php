<?php

include 'config.php';

$username = 'almas';
$password = 'sifra123';
$created_at = '2023-07.01';

echo $password . "<br>";

$hashed_password = password_hash($password, PASSWORD_DEFAULT); // kriptujemo password

echo $hashed_password . "<br>";

$sql = "INSERT INTO admins (username, created_at ,password) VALUES (?, ?, ?)";

$run = $conn->prepare($sql);
$run->bind_param("sss", $username, $created_at ,$hashed_password); // tri sss zato sto imamo tri ???
$run->execute();