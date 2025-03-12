<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($_SESSION['user_id'], $data['content'])) {
    $user_id = $_SESSION['user_id'];
    $content = $conn->real_escape_string($data['content']);

    $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Post added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add post"]);
    }
} else {
    echo json_encode(["error" => "Unauthorized"]);
}

$conn->close();
