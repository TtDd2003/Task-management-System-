<?php
session_start();
include '../conn.php';

// Always return JSON
header("Content-Type: application/json");

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit;
}

try {
    $sql = "SELECT id, task_name, comments, submission_date 
            FROM checklist 
            WHERE assigned_to = ? AND comments IS NOT NULL AND comments != ''
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
    "id"        => "CHK-" . $row['id'], // formatted ID like in tasks
    "task_name" => $row['task_name'],
    "comments"  => $row['comments'],
    "date"      => $row['submission_date']
];

    }

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Server error: " . $e->getMessage()
    ]);
}
