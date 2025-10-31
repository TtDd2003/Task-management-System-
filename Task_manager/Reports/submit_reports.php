<?php
include('../conn.php');
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["status"=>"error","message"=>"Database connection failed"]);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $project_id = $conn->real_escape_string($_POST['project_id']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $report_title = $conn->real_escape_string($_POST['report_title']);
    $report_description = $conn->real_escape_string($_POST['report_description']);
    $date_of_work = $conn->real_escape_string($_POST['date_of_work']);
    $hours_spent = $conn->real_escape_string($_POST['hours_spent']);
    $task_status = $conn->real_escape_string($_POST['task_status']); // ✅ FIXED

    if(!$project_id || !$user_id || !$report_title || !$date_of_work || !$hours_spent){
        echo json_encode(["status"=>"error","message"=>"Required fields missing"]);
        exit;
    }

    // Handle file upload
    $report_file = null;
    if(isset($_FILES['report_file']) && $_FILES['report_file']['error'] === UPLOAD_ERR_OK){
        $uploadDir = 'uploads/';
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileTmp = $_FILES['report_file']['tmp_name'];
        $fileName = time().'_'.basename($_FILES['report_file']['name']);
        $filePath = $uploadDir.$fileName;

        if(move_uploaded_file($fileTmp, $filePath)){
            $report_file = $filePath;
        } else {
            echo json_encode(["status"=>"error","message"=>"File upload failed"]);
            exit;
        }
    }

    $sql = "INSERT INTO reports 
        (project_id, user_id, report_title, report_file, report_description, date_of_work, hours_spent, task_status)
        VALUES 
        ('$project_id','$user_id','$report_title','".($report_file ?? '')."','$report_description','$date_of_work','$hours_spent','$task_status')";

    if($conn->query($sql) === TRUE){
        echo json_encode(["status"=>"success","message"=>"Report submitted successfully"]);
    } else {
        echo json_encode(["status"=>"error","message"=>$conn->error]);
    }
}

$conn->close();
?>
