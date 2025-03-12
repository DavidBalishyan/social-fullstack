<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'], $data['password'])) {
    $email = $conn->real_escape_string($data['email']);
    $password = $data['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["message" => "Login successful", "user_id" => $user['id']]);
    } else {
        echo json_encode(["error" => "Invalid email or password"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}

$conn->close();
