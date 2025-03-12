<?php
$host = "MariaDB-11.2";
$user = "root";
$pass = "";
$dbname = "app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}else {
    die("OK TEST 200");
}
