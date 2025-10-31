<?php
error_reporting(0);  // or E_ALL during dev
include('../conn.php');
header('Content-Type: application/json');

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$conn->set_charset("utf8");

$result = $conn->query("SELECT project_id, project_name FROM projects ORDER BY project_name ASC");
if(!$result){
    echo json_encode([]);
    exit;
}

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);
$conn->close();
?>
