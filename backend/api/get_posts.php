<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

// Fetch posts with like count
$sql = "SELECT posts.id, posts.user_id, posts.content, posts.created_at, 
               (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS likes_count 
        FROM posts 
        ORDER BY posts.created_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    echo json_encode(["success" => true, "posts" => $posts]);
} else {
    echo json_encode(["success" => false, "message" => "No posts found"]);
}

$conn->close();

