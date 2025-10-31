<?php
include('../conn.php');

// CASE 1: FETCH DATA (AJAX GET for modal pre-fill)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "
      SELECT  u.first_name, u.last_name, u.email, i.username, i.phone_number
      FROM users AS u LEFT JOIN info_user AS i
        ON u.id = i.user_id  WHERE u.id = $id ";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        http_response_code(500);
        exit("DB error");
    }
    $user = mysqli_fetch_assoc($res);
    header('Content-Type: application/json');
    echo json_encode($user ?? []);
    exit;
}

// CASE 2: UPDATE DATA (AJAX POST from modal form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        http_response_code(400);
        echo "Missing user ID";
        exit;
    }
    $id = (int)$_POST['id'];
    $username   = $conn->real_escape_string($_POST['username']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name  = $conn->real_escape_string($_POST['last_name']);
    $email      = $conn->real_escape_string($_POST['email']);
    $phone      = $conn->real_escape_string($_POST['phone_number']);

    // Update users
    $user_sql = " UPDATE users  SET first_name = '$first_name', last_name = '$last_name', email = '$email'
      WHERE id = $id ";

    // Upsert info_user
    $info_sql = "
      INSERT INTO info_user (user_id, username, phone_number) VALUES ($id, '$username', '$phone') ON DUPLICATE KEY UPDATE
        username = VALUES(username), phone_number = VALUES(phone_number) ";

    if (mysqli_query($conn, $user_sql) && mysqli_query($conn, $info_sql)) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}

// If reached without GET or POST id
http_response_code(400);
echo "Invalid request.";
exit;
?>
