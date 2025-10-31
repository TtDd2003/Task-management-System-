<?php
include('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = (int) $_POST['id'];

    $query = "DELETE FROM users WHERE id = $userId";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>
