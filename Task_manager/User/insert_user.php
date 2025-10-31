<?php
session_start();
include('../conn.php');

header('Content-Type: application/json');

// Initialize response
$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch fields from form
    $firstName        = $_POST['firstName'] ?? '';
    $lastName         = $_POST['lastName'] ?? '';
    $email            = $_POST['email'] ?? '';
    $password         = $_POST['password'] ?? '';
    $confirmPassword  = $_POST['confirmPassword'] ?? '';

    // Validate
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $response['message'] = 'Please fill all required fields.';
        echo json_encode($response);
        exit;
    }

    if ($password !== $confirmPassword) {
        $response['message'] = 'Passwords do not match.';
        echo json_encode($response);
        exit;
    }

    // Escape and hash
    $firstNameEsc = mysqli_real_escape_string($conn, $firstName);
    $lastNameEsc  = mysqli_real_escape_string($conn, $lastName);
    $emailEsc     = mysqli_real_escape_string($conn, $email);
    $hash         = password_hash($password, PASSWORD_DEFAULT);

    $createdAt = date('Y-m-d H:i:s');
    $createdBy = $_SESSION['username'] ?? 'Unknown';

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$emailEsc'");
    if (mysqli_num_rows($check) > 0) {
        $response['message'] = 'Email already exists.';
        echo json_encode($response);
        exit;
    }

    // Insert user
    $query = "INSERT INTO users (first_name, last_name, email, password, created_at, created_by)
              VALUES ('$firstNameEsc', '$lastNameEsc', '$emailEsc', '$hash', '$createdAt', '$createdBy')";

    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
        $response['message'] = 'Registration successful!';
    } else {
        $response['message'] = 'Database error: ' . mysqli_error($conn);
    }

    echo json_encode($response);
} else {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
