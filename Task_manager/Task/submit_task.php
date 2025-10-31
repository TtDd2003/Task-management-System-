<?php
session_start();
include '../conn.php';

// Always return JSON for fetch()
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['task_id']) ? (int)$_POST['task_id'] : null;

    $userId = $_SESSION['user_id'] ?? null;

    if (!$taskId || !$userId) {
        echo json_encode(["status" => "error", "message" => "Invalid request."]);
        exit;
    }

    // ========= 1. Handle NOTE ========= //
    if (!empty($_POST['description']) && empty($_FILES['proof_file']['name'])) {
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $updateQuery = "UPDATE checklist 
                        SET comments = '$description' 
                        WHERE id = '$taskId' AND assigned_to = '$userId'";

        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(["status" => "success", "message" => "Note saved successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB update failed: " . mysqli_error($conn)]);
        }
        exit;
    }

    // ========= 2. Handle FILE UPLOAD ========= //
    if (!empty($_FILES['proof_file']) && $_FILES['proof_file']['error'] === 0) {
        $file = $_FILES['proof_file'];
        $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "Invalid file type."]);
            exit;
        }

        $uploadDir = __DIR__ . "/proof/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFilename = uniqid("proof_") . '.' . $ext;
        $uploadPath = $uploadDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $relativePath = "proof/" . $newFilename;

            $updateQuery = "UPDATE checklist  
                            SET proof_file = '$relativePath', status = 'Completed'  
                            WHERE id = '$taskId' AND assigned_to = '$userId'";

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

    // ========= 3. Nothing valid ========= //
    echo json_encode(["status" => "error", "message" => "No valid data provided."]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid access method."]);
}
?>