<?php
include '../conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = " SELECT u.id, u.first_name, u.last_name, u.email, i.username, i.phone_number FROM users AS u LEFT JOIN info_user AS i ON u.id = i.user_id WHERE u.id = $id
    ";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>
