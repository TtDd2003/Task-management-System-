<?php
// ======================
// Task Assignment Script (Simplified, No Email Column)
// ======================

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
ob_start();

include '../conn.php';
session_start(); // Ensure session is started

// Check DB connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// ===== Get and sanitize form inputs =====
$task_name        = isset($_POST['taskTitle']) ? $conn->real_escape_string($_POST['taskTitle']) : '';
$task_description = isset($_POST['taskDescription']) ? $conn->real_escape_string($_POST['taskDescription']) : '';
$assignee_name    = isset($_POST['assignee']) ? $conn->real_escape_string($_POST['assignee']) : '';
$priority         = isset($_POST['priority']) ? $conn->real_escape_string($_POST['priority']) : '';
$submission_date  = isset($_POST['dueDate']) ? $_POST['dueDate'] : '';
$category         = isset($_POST['project']) ? $conn->real_escape_string($_POST['project']) : '';
$note             = isset($_POST['additionalNotes']) ? $conn->real_escape_string($_POST['additionalNotes']) : '';
$notify_user      = isset($_POST['notifyUser']) ? 1 : 0;
$assigned_by      = $_SESSION['user_id'] ?? null;

// Check if user is logged in
if (!$assigned_by) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

// ===== Lookup assignee in DB =====
$assigned_to = 0;
$assignee_email = '';

if ($assignee_name !== '') {
    $name_parts = explode(' ', $assignee_name, 2);
    $first_name = $conn->real_escape_string($name_parts[0]);
    $last_name  = isset($name_parts[1]) ? $conn->real_escape_string($name_parts[1]) : '';

    $query  = "SELECT id, email FROM users WHERE first_name='$first_name' AND last_name='$last_name' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $userRow        = $result->fetch_assoc();
        $assigned_to    = (int)$userRow['id'];
        $assignee_email = $userRow['email'];
    } else {
        echo json_encode(["success" => false, "message" => "Assignee name not found."]);
        exit;
    }
}

// ===== Validate required fields =====
if (empty($task_name) || empty($task_description) || !$assigned_to || empty($priority) || empty($submission_date) || empty($category)) {
    echo json_encode(["success" => false, "message" => "Please fill all required fields."]);
    exit;
}

// ===== Insert task into DB =====
$sql = "INSERT INTO checklist
    (task_name, task_description, assigned_to, assigned_by, priority, submission_date, status, category, note, notify_user)
    VALUES
    ('$task_name', '$task_description', $assigned_to, $assigned_by, '$priority', '$submission_date', 'pending', '$category', '$note', $notify_user)";

if ($conn->query($sql)) {
    // ===== Simulate Fake Email Sending =====
    $email_msg = $notify_user ? " (Simulated email notification sent to $assignee_name)" : "";

    $response = [
        "success" => true,
        "message" => "Task assigned successfully!" . $email_msg
    ];
} else {
    $response = [
        "success" => false,
        "message" => "Database error: " . $conn->error
    ];
}

ob_end_clean();
echo json_encode($response);
$conn->close();
exit;
?>

