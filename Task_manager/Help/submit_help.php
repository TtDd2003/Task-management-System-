<?php
session_start();
include '../conn.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];

// ================== CASE 1: Updating existing HELP task (Note / Proof) ================== //
if (!empty($_POST['task_id'])) {
    $taskIdRaw = $_POST['task_id'];
    $taskId = (int) str_replace("HELP-", "", $taskIdRaw);

    // --- Save Note ---
    if (!empty($_POST['description']) && empty($_FILES['proof_file']['name'])) {
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $updateQuery = "UPDATE helper SET note = '$description' 
                        WHERE ticket_id = '$taskId' AND helper_id = '$userId'";

        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(["status" => "success", "message" => "Note saved successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB update failed: " . mysqli_error($conn)]);
        }
        exit;
    }

    // --- Save Proof File ---
    if (!empty($_FILES['proof_file']) && $_FILES['proof_file']['error'] === 0) {
        $file = $_FILES['proof_file'];
        $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "Invalid file type."]);
            exit;
        }

        $uploadDir = __DIR__ . "/proof_help/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFilename = uniqid("proof_help_") . '.' . $ext;
        $uploadPath = $uploadDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $relativePath = "proof_help/" . $newFilename;

            $updateQuery = "UPDATE helper 
                            SET proof = '$relativePath', status = 'Completed' 
                            WHERE ticket_id = '$taskId' AND helper_id = '$userId'";

            if (mysqli_query($conn, $updateQuery)) {
                echo json_encode(["status" => "success", "message" => "File uploaded & task completed."]);
            } else {
                echo json_encode(["status" => "error", "message" => "DB update failed: " . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed."]);
        }
        exit;
    }
}

// ================== CASE 2: Creating new HELP task ================== //

$assign_by       = $_SESSION['user_id'];
$helper_name     = $_POST['helper_name'] ?? '';
$helper_role     = $_POST['helper_role'] ?? '';
$task_title      = $_POST['task_title'] ?? '';
$estimated_time  = $_POST['estimated_time'] ?? '';
$priority        = $_POST['priority'] ?? null;
$submission_date = date("Y-m-d H:i:s");

if (!empty($helper_name) && !empty($task_title) && !empty($priority)) {
    // Find helper_id
    $name_parts = explode(' ', $helper_name, 2);
    $first_name = mysqli_real_escape_string($conn, $name_parts[0]);
    $last_name  = isset($name_parts[1]) ? mysqli_real_escape_string($conn, $name_parts[1]) : '';

    $query = "SELECT id FROM users WHERE first_name = '$first_name' AND last_name = '$last_name' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $helper_id = (int)mysqli_fetch_assoc($result)['id'];
    } else {
        echo json_encode(["status" => "error", "message" => "Helper not found in users table."]);
        exit;
    }

    $sql = "INSERT INTO helper (help_title, assigned_by, helper_id, helper_role, submission_date, estimated_time, priority) 
            VALUES ('$task_title', $assign_by, $helper_id, '$helper_role', '$submission_date', '$estimated_time', '$priority')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Helper task created successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request data."]);
?>
