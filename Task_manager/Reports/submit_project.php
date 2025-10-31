<?php
include('../conn.php');
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data
    $project_name = $_POST['project_name'] ?? '';
    $description  = $_POST['description'] ?? '';
    $start_date   = $_POST['start_date'] ?? '';
    $deadline     = $_POST['deadline'] ?? '';
    $duration     = $_POST['duration'] ?? '';
    $revenue      = $_POST['revenue'] ?? null;
    $team_size    = $_POST['team_size'] ?? null;
    $status       = $_POST['status'] ?? 'pending';

    if (empty($project_name) || empty($start_date) || empty($deadline) || empty($status)) {
        echo json_encode(["status" => "error", "message" => "Required fields are missing"]);
        exit;
    }

    // Insert query
    $sql = "INSERT INTO projects (project_name, description, start_date, deadline, duration, revenue, team_size, status) 
            VALUES ('$project_name', '$description', '$start_date', '$deadline', '$duration', 
                    " . ($revenue !== null ? "'$revenue'" : "NULL") . ", 
                    " . ($team_size !== null ? "'$team_size'" : "NULL") . ", 
                    '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Project added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

$conn->close();
?>