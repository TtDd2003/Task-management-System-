
<?php

header('Content-Type: application/json');
include('../conn.php');

// allow optional ?limit=1 for the "recent" container
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 0;

$sql = "SELECT id, title, message, category, notice_date FROM notice ORDER BY id DESC";

if ($limit > 0) {  
    $sql .= " LIMIT " . $limit;  // safe cast to int above; add LIMIT
}

$result = $conn->query($sql);

$notices = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
}

echo json_encode([
    "success" => true,
    "notices" => $notices
]);

$conn->close();
?>