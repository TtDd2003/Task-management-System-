<?php
session_start();
include '../conn.php';

$userId = $_SESSION['user_id'] ?? null;
$tasks = [];

if ($userId) {
    // Escape input values
    $taskName = mysqli_real_escape_string($conn, $_GET['task_name'] ?? '');
    $assignedBy = mysqli_real_escape_string($conn, $_GET['assigned_by'] ?? '');
    $priority = mysqli_real_escape_string($conn, $_GET['priority'] ?? '');
    $submissionDate = mysqli_real_escape_string($conn, $_GET['submission_date'] ?? '');
    $statusFilter = mysqli_real_escape_string($conn, $_GET['status'] ?? '');

    // Base query: only tasks assigned to logged-in user
    $query = "SELECT * FROM checklist WHERE assigned_to = '$userId'";

    // Apply filters
    if (!empty($taskName)) {
        $query .= " AND task_name LIKE '%$taskName%'";
    }

    if (!empty($assignedBy)) {
        $query .= " AND assigned_by LIKE '%$assignedBy%'";
    }

    if (!empty($priority)) {
        $query .= " AND priority LIKE '%$priority%'";
    }

    if (!empty($submissionDate)) {
        $query .= " AND submission_date = '$submissionDate'";
    }

    if (!empty($statusFilter)) {
        $query .= " AND status = '$statusFilter'";
    }

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
    }

    $hasTasks = count($tasks) > 0;
} else {
    $hasTasks = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Task Checklist</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- ===== Filter Section ===== -->
  <form class="navbar bg-white p-3 rounded shadow-sm mb-6 mt-4 mx-auto col-10 border" method="get">
    <div class="container-fluid row g-3 align-items-center">

      <div class="col-md-3">
        <input type="text" name="assigned_by" class="form-control" placeholder="Search by Assigned By"
          value="<?= htmlspecialchars($_GET['assigned_by'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="task_name" class="form-control" placeholder="Search by Task Name"
          value="<?= htmlspecialchars($_GET['task_name'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <input type="date" name="submission_date" class="form-control" placeholder="Search by Date"
          value="<?= htmlspecialchars($_GET['submission_date'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="priority" class="form-control" placeholder="Search by Priority"
          value="<?= htmlspecialchars($_GET['priority'] ?? '') ?>">
      </div>

      <div class="col-md-3 d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary me-2">
          <i class="fas fa-search me-1"></i> Filter
        </button>

        <button type="button" class="btn btn-success me-2" onclick="window.location.href='user_task.php'">
          <i class="fa-solid fa-rotate"></i> Reset
        </button>

        <a href="add_task.php" class="btn btn-warning">
          <i class="fa-solid fa-plus"></i> New
        </a>
      </div>

    </div>
  </form>

  <h1 class="fw-bold text-dark text-center mt-4">User Checklist Task</h1>

  <div class="max-w-6xl mx-auto mt-6 p-6 bg-white rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-6 border-b pb-2">
      <h2 class="text-2xl font-semibold text-gray-700">
        <i class="fa-solid fa-list-check text-blue-600 me-2"></i>
        Checklist Tasks for 
        <span class="text-blue-700">
          <?= htmlspecialchars($_SESSION['user_first_name'] ?? 'User') ?>
        </span>
      </h2>

      <!-- Filter Dropdown -->
      <form method="get" class="flex items-center space-x-2">
        <label for="status" class="text-gray-700 font-medium me-2">Filter by:</label>
        <select name="status" id="status" class="form-select form-select-sm w-auto border border-gray-300 rounded px-3 py-1" onchange="this.form.submit()">
          <option value="">All</option>
          <option value="Pending" <?= ($_GET['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option value="Completed" <?= ($_GET['status'] ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
          <option value="Working" <?= ($_GET['status'] ?? '') === 'Working' ? 'selected' : '' ?>>Working</option>
        </select>
      </form>
    </div>

    <?php if ($hasTasks): ?>
      <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full text-sm text-left border border-gray-300 bg-white">
          <thead class="bg-blue-600 text-white uppercase text-xs tracking-wider text-center">
            <tr>
              <th class="px-6 py-3">Task Title</th>
              <th class="px-6 py-3">Assigned By</th>
              <th class="px-6 py-3">Submission Date</th>
              <th class="px-6 py-3">Priority</th>
              <th class="px-6 py-3">Msg</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tasks as $task): ?>
              <tr class="border-b hover:bg-gray-50 text-center">
                <td class="px-6 py-3"><?= htmlspecialchars($task['task_name']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($task['assigned_by']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($task['submission_date']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($task['priority']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($task['note'] ?? '') ?></td>
                <td class="px-6 py-3">
                  <form method="post" action="submit_task.php" enctype="multipart/form-data">
                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id'] ?? '') ?>">

                    <label class="btn btn-outline-info btn-sm mb-1">
                      <i class="fa-solid fa-upload me-1"></i> 
                      <input type="file" name="proof_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" hidden required>
                    </label>

                    <button type="submit" class="btn btn-success btn-sm w-100 mt-1">
                      <i class="fa-solid fa-paper-plane"></i> 
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="flex items-center gap-3 p-4 bg-yellow-100 text-yellow-800 rounded-md mt-4">
        <i class="fa-solid fa-circle-info text-xl"></i>
        <div>
          <p class="font-semibold">No Tasks Found</p>
          <p class="text-sm">You currently have no checklist tasks assigned.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../asset/js/task.js" defer></script>

</body>
</html>
