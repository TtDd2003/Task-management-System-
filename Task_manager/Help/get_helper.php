<?php
include '../conn.php';

$baseUrl = "http://localhost/Task_manager/User/";

// ---------------- Get Helpers with Assigned Tasks ----------------
$sql = "SELECT h.ticket_id, h.help_title, h.assigned_by, h.helper_id, h.helper_role, DATE(h.submission_date) AS submission_date, h.status, 
        i.profile_picture, u.first_name, u.last_name FROM helper h
        LEFT JOIN info_user i ON h.helper_id = i.user_id  LEFT JOIN users u ON h.helper_id = u.id";

$result = $conn->query($sql);

$helpers = [];
$busyHelpersIds = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = !empty($row['profile_picture'])  
                     ? $baseUrl . $row['profile_picture']   
                     : $baseUrl . "uploads/default.png";    

        //  Normalize status here
        $status = strtolower($row['status']);
        switch ($status) {
            case 'low': 
                $status = 'pending'; 
                break;
            case 'medium': 
                $status = 'in progress'; 
                break;
            case 'high': 
                $status = 'working'; 
                break;
            default:
                $status = 'unknown';
        }
        
        $helpers[] = [
            "id"          => $row['ticket_id'],
            "name"        => trim($row['first_name'] . ' ' . $row['last_name']),
            "role"        => $row['helper_role'],
            "image"       => $imagePath,
            "skills"      => ["PHP", "SQL", "HTML"], // dummy
            "rating"      => 4.5, 
            "assignments" => $row['help_title'],
            "status"      => $row['status'],        
            "assignedBy"  => $row['assigned_by'],
            "SubmitDate"  => $row['submission_date']
        ];
        $busyHelpersIds[] = $row['helper_id']; // track busy helpers
    }
}

// ---------------- Count Total Helpers (users table) ----------------
$sqlTotal = "SELECT COUNT(*) AS total FROM users ";
$totalRes = $conn->query($sqlTotal);
$totalRow = $totalRes->fetch_assoc();
$totalHelpers = $totalRow['total'];

// ---------------- Count Busy Helpers ----------------
$busyHelpers = count(array_unique($busyHelpersIds));

$availableHelpers = $totalHelpers - $busyHelpers; //(Available = total - busy)//

$response = [
    "helpers" => $helpers,
    "stats" => [
        "total"     => $totalHelpers,
        "busy"      => $busyHelpers,
        "available" => $availableHelpers,
        "assigned"  => $busyHelpers // same as busy
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
