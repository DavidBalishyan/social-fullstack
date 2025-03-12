<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['username'], $data['email'], $data['password'])) {
    $username = $conn->real_escape_string($data['username']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User registered successfully"]);
    } else {
        echo json_encode(["error" => "Registration failed"]);
    }
} else {
    echo json_encode(["error" => "Invalid data"]);
}

$conn->close();
