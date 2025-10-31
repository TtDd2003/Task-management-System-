<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();

include '../conn.php';

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

$assigned_by = $_SESSION['user_id'] ?? null;

if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "CSV file upload failed."]);
    exit;
}

$fileTmp = $_FILES['csvFile']['tmp_name'];
$handle = fopen($fileTmp, "r");
if ($handle === false) {
    echo json_encode(["success" => false, "message" => "Unable to read CSV file."]);
    exit;
}

$successCount = 0;
$failCount = 0;
$errors = [];

// Skip header row
fgetcsv($handle);

while (($row = fgetcsv($handle, 1000, ",")) !== false) {
    // Skip fully empty rows
    if (count(array_filter($row)) === 0) continue;

    // Ensure row has exactly 7 columns
    $row = array_pad($row, 7, '');

    $assignee_name    = $conn->real_escape_string(trim($row[0]));
    $task_name        = $conn->real_escape_string(trim($row[1]));
    $task_description = $conn->real_escape_string(trim($row[2]));
    $priority         = strtolower(trim($row[3]));
    $csvDate          = trim($row[4]);
    $category         = $conn->real_escape_string(trim($row[5]));
    $note             = $conn->real_escape_string(trim($row[6]));
    $notify_user      = 0;

    // --- Date conversion ---
    $submission_date = null;

    if ($csvDate !== '') {
        // DD.MM.YYYY
        if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $csvDate, $matches)) {
            $day   = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $year  = $matches[3];
            $submission_date = "$year-$month-$day";
        }
        // MM/DD/YYYY
        else if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $csvDate, $matches)) {
            $month = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $day   = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $year  = $matches[3];
            $submission_date = "$year-$month-$day";
        }
    }

    // Validate date
    if (!$submission_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $submission_date) || !strtotime($submission_date)) {
        $failCount++;
        $errors[] = "Invalid date format for row: " . implode(", ", $row);
        continue;
    }

    // --- Keep your previous assignee and insertion logic exactly ---
    $assigned_to = 0;
    if ($assignee_name !== '') {
        $name_parts = explode(' ', $assignee_name, 2);
        $first_name = $conn->real_escape_string($name_parts[0]);
        $last_name  = isset($name_parts[1]) ? $conn->real_escape_string($name_parts[1]) : '';

        $query = "SELECT id FROM users WHERE first_name = '$first_name' AND last_name = '$last_name' LIMIT 1";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $assigned_to = (int)$result->fetch_assoc()['id'];
        }
    }

    if (
        empty($task_name) || empty($task_description) || !$assigned_to ||
        empty($priority) || empty($submission_date) || empty($category)
    ) {
        $failCount++;
        $errors[] = "Missing fields or invalid assignee for row: " . implode(", ", $row);
        continue;
    }

    $sql = "INSERT INTO checklist 
        (task_name, task_description, assigned_to, assigned_by, priority, submission_date, status, category, note, notify_user) 
        VALUES 
        ('$task_name', '$task_description', $assigned_to, " . ($assigned_by ?: "NULL") . ", '$priority', '$submission_date', 'pending', '$category', '$note', $notify_user)";

    if ($conn->query($sql)) {
        $successCount++;
    } else {
        $failCount++;
        $errors[] = "DB error on row: " . implode(", ", $row) . " | Error: " . $conn->error;
    }
}

fclose($handle);

$response = [
    "success" => true,
    "inserted" => $successCount,
    "failed" => $failCount,
    "errors" => $errors
];

echo json_encode($response);
$conn->close();
exit;
?>
