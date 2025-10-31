<?php
include('../conn.php');
header('Content-Type: application/json');

// Get page & limit from query string (default: page 1, 5 per page)
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

// Get total rows
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM `leave`");
$totalRows = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch paginated data (JOIN with users table)
$sql = "SELECT l.*, u.first_name AS employee_name 
        FROM `leave` l
        JOIN users u ON l.user_code = u.user_code
        ORDER BY l.start_date DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$rows = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $rows[] = [
            "id"      => $row["leave_id"],   // real leave id
            "user_code" => $row["user_code"],
            "name"    => $row["employee_name"], 
            "type"    => $row["leave_type"],
            "start"   => date('Y-m-d', strtotime($row["start_date"])),
            "end"     => date('Y-m-d', strtotime($row["end_date"])),
            "status"  => $row["status"] ?? "pending",
            "reason"  => $row["leave_reason"],
            "department" => $row["department"],
            "contact_name" => $row["contact_name"],
            "contact_no" => $row["contact_no"]
        ];

    }
}

// Return data + pagination info
echo json_encode([
    "data" => $rows,
    "page" => $page,
    "limit" => $limit,
    "totalPages" => $totalPages,
    "totalRows" => $totalRows
]);

$conn->close();
?>
