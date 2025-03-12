<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($_SESSION['user_id'], $data['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $data['post_id'];

    $check = $conn->query("SELECT * FROM likes WHERE user_id='$user_id' AND post_id='$post_id'");

    if ($check->num_rows > 0) {
        echo json_encode(["error" => "Already liked"]);
    } else {
        $conn->query("INSERT INTO likes (user_id, post_id) VALUES ('$user_id', '$post_id')");
        echo json_encode(["message" => "Post liked"]);
    }
} else {
    echo json_encode(["error" => "Unauthorized"]);
}

$conn->close();
