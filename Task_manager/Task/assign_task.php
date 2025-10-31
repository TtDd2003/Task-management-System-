<?php
// ======================
// Task Assignment Script (Updated for Mailgun API)
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

// ===== Insert task into DB (sent_email = 0 initially) =====
$sql = "INSERT INTO checklist
    (task_name, task_description, assigned_to, assigned_by, priority, submission_date, status, category, note, notify_user, sent_email)
    VALUES
    ('$task_name', '$task_description', $assigned_to, $assigned_by, '$priority', '$submission_date', 'pending', '$category', '$note', $notify_user, 0)";

if ($conn->query($sql)) {
    $task_id = $conn->insert_id;
    $mailSent = false;

    if ($notify_user == 1) {
        // ===== Mailgun API via HTTP POST =====
        $apiKey = getenv('MAILGUN_API_KEY');
        $domain = getenv('MAILGUN_DOMAIN');

        $emailMessage = "
        <html>
        <body>
        <p>Hi <b>$assignee_name</b>,</p>
        <p>You have been assigned a new task in the Task Management System.</p>
        <p><b>Task Title:</b> $task_name<br>
        <b>Description:</b> $task_description<br>
        <b>Priority:</b> $priority<br>
        <b>Due Date:</b> $submission_date<br>
        <b>Category:</b> $category</p>
        <p>Please log in to your dashboard to view details.</p>
        <p>Regards,<br>Task Management System</p>
        </body>
        </html>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/$domain/messages");
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'from'    => 'Task Manager <noreply@yourdomain.com>',
            'to'      => $assignee_email,
            'subject' => "New Task Assigned: $task_name",
            'html'    => $emailMessage
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $mailSent = true;
        }
    }

    // ===== Update sent_email column =====
    $sent_email = $mailSent ? 1 : 0;
    $updateQuery = "UPDATE checklist SET sent_email = $sent_email WHERE id = $task_id";
    $conn->query($updateQuery);

    // ===== Prepare JSON response =====
    $response = [
        "success" => true,
        "message" => "Task assigned successfully!" . ($mailSent ? " Email notification sent to $assignee_name." : "")
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
