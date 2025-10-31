<?php

header('Content-Type: application/json');
session_start();
include('../conn.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $category = trim($_POST['category'] ?? 'general');
    $notice_date = !empty($_POST['date']) ? $_POST['date'] : null;

    // Logged-in user ID
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "User not logged in."]);
        exit;
    }

    // Validation
    if (empty($title) || empty($message) || empty($category)) {
        echo json_encode(["success" => false, "message" => "All required fields must be filled."]);
        exit;
    }

    // Escape inputs to avoid SQL injection
    $title = mysqli_real_escape_string($conn, $title);
    $message = mysqli_real_escape_string($conn, $message);
    $category = mysqli_real_escape_string($conn, $category);
    $notice_date = $notice_date ? mysqli_real_escape_string($conn, $notice_date) : null;

    // Build query
    $sql = "INSERT INTO notice (title, message, category, notice_date, user_id) VALUES ('$title', '$message', '$category', " . 
            ($notice_date ? "'$notice_date'" : "NULL") . ", '$user_id')";

    if (mysqli_query($conn, $sql)) 
    {
        $insert_id = mysqli_insert_id($conn);

        echo json_encode([
            "success" => true,
            "message" => "Notice saved successfully!",
            "notice" => [
                "id" => $insert_id,
                "title" => $title,
                "message" => $message,
                "category" => $category,
                "date" => $notice_date,
                "user_id" => $user_id
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save notice"]);
    }

} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

$conn->close();
?>