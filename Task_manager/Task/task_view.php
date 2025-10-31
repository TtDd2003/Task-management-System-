<?php
include '../conn.php';

header('Content-Type: application/json');

$user_id = intval($_GET['user_id'] ?? 0);

if ($user_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT task_name, task_description, priority, submission_date, status , assigned_by
        FROM checklist 
        WHERE assigned_to = $user_id";

$result = mysqli_query($conn, $sql);

$tasks = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}

echo json_encode($tasks);
