<?php
include('../conn.php');

header('Content-Type: application/json'); // respond as JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect POST data
    $leave_id       = isset($_POST['leave_id']) ? intval($_POST['leave_id']) : 0;
    $employee_id    = $conn->real_escape_string($_POST['user_code']);
    $department     = $conn->real_escape_string($_POST['department']);
    $leave_type     = $conn->real_escape_string($_POST['leave_type']);
    $start_date     = $conn->real_escape_string($_POST['start_date']);
    $end_date       = $conn->real_escape_string($_POST['end_date']);
    $reason         = $conn->real_escape_string($_POST['leave_reason']);
    $status         = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'pending';

    // Optional fields
    $contact_name   = !empty($_POST['contact_name']) ? "'" . $conn->real_escape_string($_POST['contact_name']) . "'" : "NULL";
    $contact_number = !empty($_POST['contact_no']) ? "'" . $conn->real_escape_string($_POST['contact_no']) . "'" : "NULL";
    $acknowledge    = isset($_POST['acknowledge']) && $_POST['acknowledge'] === 'on' ? "'Yes'" : "'No'";

    if ($leave_id > 0) {
        //  UPDATE existing leave
        $sql = "UPDATE `leave`  SET leave_type='$leave_type',  leave_reason='$reason',  start_date='$start_date',  end_date='$end_date', department='$department', contact_name=$contact_name,  contact_no=$contact_number,  acknowledge=$acknowledge, status='$status'
            WHERE leave_id=$leave_id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Leave application updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $conn->error]);
        }

    } else {
        // ➕ INSERT new leave (your original logic)
        $checkSql = "SELECT * FROM `leave` WHERE user_code = '$employee_id' AND start_date = '$start_date' AND end_date = '$end_date'";
        $result = $conn->query($checkSql);

        if ($result && $result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Leave request already exists for this period!"]);
        } else {
            $sql = "INSERT INTO `leave` 
                    (leave_type, leave_reason, start_date, end_date, user_code, department, contact_name, contact_no, acknowledge, status)
                    VALUES 
                    ('$leave_type', '$reason', '$start_date', '$end_date', '$employee_id', '$department', $contact_name, $contact_number, $acknowledge, '$status')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Leave application submitted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            }
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>
