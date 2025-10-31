<?php
session_start();
include '../conn.php';

$usersTasks = [];

$limit = 3; // Records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ===== Filter Handling (username, email only) =====
$filterConditions = [];
if (!empty($_GET['username'])) {
    $filterConditions[] = "iu.username LIKE '%" . mysqli_real_escape_string($conn, $_GET['username']) . "%'";
}
if (!empty($_GET['email'])) {
    $filterConditions[] = "u.email LIKE '%" . mysqli_real_escape_string($conn, $_GET['email']) . "%'";
}
$filterSQL = count($filterConditions) > 0 ? ' AND ' . implode(' AND ', $filterConditions) : '';

// ===== Pagination count query =====
$countQuery = "SELECT COUNT(*) AS total_rows FROM ( SELECT c.assigned_to FROM checklist c JOIN users u ON u.id = c.assigned_to JOIN info_user iu ON iu.user_id = u.id WHERE 1 $filterSQL GROUP BY c.assigned_to ) AS subquery";

$countResult = mysqli_query($conn, $countQuery);
$totalPages = 1;
if ($countResult) {
    $row = mysqli_fetch_assoc($countResult);
    $totalRows = $row['total_rows'] ?? 0;
    $totalPages = ceil($totalRows / $limit);
}

// ===== Main data query =====
$query = "SELECT u.id AS id, iu.username, u.email, COUNT(c.id) AS total_tasks,
    (SELECT CONCAT(assigner.first_name, ' ', assigner.last_name) FROM users assigner WHERE assigner.id = c.assigned_by LIMIT 1) 
    AS assign_by,
    SUM(CASE WHEN c.status = 'Pending' THEN 1 ELSE 0 END) AS pending_tasks,
    SUM(CASE WHEN c.status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks FROM checklist c
JOIN users u ON u.id = c.assigned_to
JOIN info_user iu ON iu.user_id = u.id
WHERE 1 $filterSQL GROUP BY c.assigned_to ORDER BY iu.username LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
$usersTasks = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usersTasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Tasks of Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 text-gray-900">

<!-- ===== Filter Section ===== -->
<form class="navbar bg-white p-3 rounded justify-content-center border shadow-sm mb-6 mt-4 mx-auto col-7" method="get">
  <div class="row g-2 align-items-center p-1 rounded justify-content-center">

      <!-- Username -->
      <div class="col-md-3">
          <input type="text" name="username" class="form-control" placeholder="Search by Username"
              value="<?= htmlspecialchars($_GET['username'] ?? '') ?>">
      </div>

      <!-- Email -->
      <div class="col-md-3">
          <input type="email" name="email" class="form-control" placeholder="Search by Email"
              value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
      </div>

      <!-- Buttons -->
      <div class="col-md-6 d-flex gap-2 justify-content-center">
          <button type="submit" class="btn btn-primary flex-grow-1">
              <i class="fas fa-search me-1"></i> Filter
          </button>
          <button type="button" class="btn btn-success flex-grow-1" onclick="window.location.href='all_user_tasks.php'">
              <i class="fa-solid fa-rotate"></i> Reset
          </button>
          <button type="button" class="btn btn-warning flex-grow-1" onclick="window.location.href='add_task.php'">
              <i class="fa-solid fa-plus"></i> New
          </button>
      </div>

  </div>
</form>

<h1 class="fw-bold text-dark text-center mb-3">All Users Task List</h1>

<!-- ===== Task Table ===== -->
<div class="max-w-6xl mx-auto p-5 bg-white rounded-xl shadow">

  <!-- Top wrapper -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-2 gap-3">
    <h2 class="text-2xl font-semibold text-gray-700">
      <i class="fa-solid fa-list-check text-blue-600 me-2"></i>
      Checklist Tasks for 
      <span class="text-blue-700">
          <?= !empty($_GET['username']) 
              ? htmlspecialchars($_GET['username']) 
              : 'All Users' ?>
      </span>
    </h2>
  </div>

  <!-- Responsive table wrapper -->
  <div class="overflow-auto w-full">
    <table class="table table-bordered table-hover align-middle min-w-[700px]">
      <thead class="table-primary text-center">
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Total Tasks</th>
          <th>Pending</th>
          <th>Completed</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usersTasks as $user): ?>
          <tr class="text-center">
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['total_tasks'] ?></td>
            <td><span class="badge bg-danger-subtle text-danger"><?= $user['pending_tasks'] ?></span></td>
            <td><span class="badge bg-success-subtle text-success"><?= $user['completed_tasks'] ?></span></td>
            <td class="d-flex flex-column gap-1 align-items-center">
              <button class="btn btn-sm btn-info view-tasks" data-userid="<?= $user['id'] ?>" data-bs-toggle="modal" data-bs-target="#taskModal">
                   <i class="fas fa-eye"></i> View
              </button>
              <a href="message_user.php?user=<?= urlencode($user['username']) ?>" class="btn btn-sm bg-yellow-100 text-yellow-800 w-75">
                <i class="fas fa-comment-dots"></i> Message
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if (empty($usersTasks)): ?>
    <div class="alert alert-warning mt-4">
      <i class="fa-solid fa-circle-info me-2"></i> No user tasks found.
    </div>
  <?php endif; ?>

  <?php if ($totalPages > 1): ?>
    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php
          $queryStr = $_GET;
          $queryStr['page'] = 1;

          if ($page > 1) {
              $queryStr['page'] = $page - 1;
              echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryStr) . '">&laquo; Prev</a></li>';
          }

          for ($i = 1; $i <= $totalPages; $i++) {
              $queryStr['page'] = $i;
              $active = $i == $page ? 'active' : '';
              echo '<li class="page-item ' . $active . '"><a class="page-link" href="?' . http_build_query($queryStr) . '">' . $i . '</a></li>';
          }

          if ($page < $totalPages) {
              $queryStr['page'] = $page + 1;
              echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryStr) . '">Next &raquo;</a></li>';
          }
        ?>
      </ul>
    </nav>
  <?php endif; ?>

  <!-- Task Details Modal -->
  <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="taskModalLabel">User Task Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                  <tr>
                    <th>#</th>
                    <th>Task Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Assign_by</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="taskDetailsBody" class="text-center">
                  <tr><td colspan="7">Loading...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
  </div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/task.js" ></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
