<?php
session_start();
$isLoggedIn = isset($_SESSION['user_first_name']);
if (!$isLoggedIn) {
    header("Location: login.php");
    exit();
}

include 'conn.php';

$userId = $_SESSION['user_id'] ?? null;

$checklistItems = [];
$helperItems = [];

if ($userId) {
    /** ============ Checklist Tasks ============ */
    $queryTasks = "SELECT id, task_name, submission_date, status FROM checklist WHERE assigned_to = '$userId' 
                   ORDER BY id DESC  LIMIT 10";
    $resultTasks = mysqli_query($conn, $queryTasks);
    while ($row = mysqli_fetch_assoc($resultTasks)) {
        $checklistItems[] = [
            'id'   => 'CHK-' . $row['id'],
            'title'=> $row['task_name'],
            'assigned_by' => null,
            'date' => $row['submission_date'],
            'status'=> strtolower($row['status'])
        ];
    }

    /** ============ Help Tickets ============ */
    $queryHelper = "SELECT ticket_id, help_title, assigned_by, submission_date, status  FROM helper  WHERE helper_id = '$userId' 
                    ORDER BY ticket_id DESC  LIMIT 5";
    $resultHelper = mysqli_query($conn, $queryHelper);
      while ($row = mysqli_fetch_assoc($resultHelper)) {
        $helperItems[] = [
            'id'   => 'HELP-' . $row['ticket_id'],
            'title'=> $row['help_title'],
            'assigned_by' => $row['assigned_by'],
            'date' => date('Y-m-d', strtotime($row['submission_date'])),  // keep only date part (YYYY-MM-DD)
            'status'=> strtolower($row['status'])
        ];
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tri Tech Task Manager</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="asset/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>

<!-- ================== NAVBAR ================== -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <!-- Left: Sidebar Toggle + Logo -->
    <div class="d-flex align-items-center">
      <button class="btn me-2" id="menuToggle"><i class="fas fa-bars"></i></button>
      <img src="asset/img/logo.PNG" alt="Logo" class="logo-img">
    </div>

    <!-- Center: Nav Links (Desktop Only) -->
    <ul class="navbar-nav d-none d-lg-flex mx-auto">
      <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
      <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
    </ul>

    <!-- Right: Profile + Settings + Mobile Nav Toggle -->
    <div class="d-flex align-items-center">
      <?php if ($isLoggedIn): ?>
        <?php
          $profilePicture = $_SESSION['profile_picture'] ?? '';
          $imagePath = (!empty($profilePicture) && file_exists("User/" . $profilePicture))
            ? "User/" . htmlspecialchars($profilePicture)
            : "asset/img/default-avatar.png";
        ?>
        <img src="<?= $imagePath ?>" alt="Profile" class="profile-img me-2">

        <!-- Settings Dropdown -->
       
      <div class="dropdown position-relative" id="customSettingsDropdown">
        <button class="btn btn-dark btn-sm d-flex align-items-center gap-1" id="settingsButton">
          <i class="fa-solid fa-gear"></i>
          <i class="fa-solid fa-caret-down small"></i>
        </button>

        <!-- Custom Dropdown Menu -->
        <ul class="dropdown-menu dropdown-menu-end shadow" id="settingsMenu">
          <li><a class="dropdown-item" href="notification.php"><i class="fas fa-bell me-2 text-warning"></i> Notifications</a></li>
          <li><a class="dropdown-item" href="User/user_profile.php"><i class="fas fa-user-cog me-2 text-primary"></i> Account Settings</a></li>
          <li><a class="dropdown-item" href="User/security.php"><i class="fas fa-shield-alt me-2 text-danger"></i> Security</a></li>
          <li><a class="dropdown-item" href="FAQ.php"><i class="fas fa-question-circle me-2 text-info"></i> Help & FAQ</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout</a></li>
        </ul>
      </div>

      <?php endif; ?>

      <!-- Mobile Nav Dropdown Button -->
      <button class="btn btn-light bg-dark btn-sm d-lg-none ms-2" id="navDropdownBtn">
        <i class="fas fa-ellipsis-v"></i>
      </button>
    </div>
  </div>
</nav>

<!-- Mobile Dropdown for Home/Contact/About -->
<div id="navMenuDropdown" class="d-lg-none">
  <a href="">Home</a>
  <a href="contact.php">Contact</a>
  <a href="about.php">About</a>
</div>


<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar" id="sidebarMenu">
      <div class="section-title">Task List</div>
      <a href="Task/user_task.php">Checklist</a>
      <a href="Task/all_task.php">All Checklist Task</a>
      <a href="Task/add_task.php">Add Checklist</a>

      <div class="section-title">Help Tickets</div>
      <a href="Help/add_helper.php">Apply Helping Task</a>
      <a href="Help/all_helper.php">All Helper</a>

      <div class="section-title">Announcements</div>
      <a href="Announcement/add_announcements.php">Add Announcements</a>
      <a href="Announcement/all_announcements.php">Show Announcements</a>

      <div class="section-title">Report</div>
      <a href="Reports/all_report.php">Check Report</a>
      <a href="Reports/add_report.php">Submit Report</a>
      <a href="Reports/add_project.php">New Project</a>

      <div class="section-title">Leave</div>
      <a href="Leave/add_leave.php">Leave Apply</a>
      <a href="Leave/all_leaves.php">List of Leaves</a>

      <div class="section-title">User</div>
      <a href="User/user_entry.php">Add User</a>
      <a href="User/list_user.php">List of User</a>
    </div>

    <!-- ✨ Overlay for background dimming -->
    <div id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="text-center">
        Welcome, <?= htmlspecialchars($_SESSION['user_first_name']) ?> 👋
      </h2>

      <!-- Chart Section -->
      <div class="row mb-4 chart-row">
        <div class="card-box shadow-sm">
          <canvas id="tasksChart"></canvas>
        </div>
        <div class="card-box shadow-sm">
          <canvas id="checklistChart"></canvas>
        </div>
        <div class="card-box shadow-sm">
          <canvas id="statusChart"></canvas>
        </div>
      </div>

      <!-- Login Profile -->
      <h5 class="mb-3">Login User Profile</h5>

      <!-- Task Notification -->
      <div class="card shadow-sm task-box border">
        <div class="card-header bg-white border-0 d-flex flex-wrap justify-content-between align-items-center">
          <h5 class="mb-0" style="color: #0066cc;"><strong>New Task Notification</strong></h5>
          <section class="button-group d-flex flex-wrap gap-2">
            <button class="btn btn-1">Completed</button>
            <button class="btn btn-2">Comments</button>
          </section>
        </div>

        <div class="card-body border">
          <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle rounded-3 overflow-hidden">
              <thead class="table-primary">
                <tr>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col">ID</th>
                  <th scope="col">Task</th>
                  <th scope="col">Date</th>
                  <th scope="col">Status</th>
                  <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody class="table-warning">
                <?php if (!empty($checklistItems) || !empty($helperItems)): ?>

                  <!-- Checklist Tasks -->
                  <?php foreach ($checklistItems as $item): ?>
                    <tr class="hover-bg-light">
                      <td class="text-center"><input type="checkbox" /></td>
                      <td><strong><?= htmlspecialchars($item['id']) ?></strong></td>
                      <td><span class="text-muted"><?= htmlspecialchars($item['title']) ?></span></td>
                      <td><span class="text-muted"><?= htmlspecialchars($item['date']) ?></span></td>
                      <td><span class="text-muted"><?= htmlspecialchars($item['status']) ?></span></td>
                      <td class="text-center">
                        <button class="btn btn-primary btn-sm me-1 note-btn"
                          data-task-id="<?= (int) str_replace('CHK-', '', $item['id']) ?>"
                          data-bs-toggle="modal" data-bs-target="#noteTaskModal">Note
                        </button>

                        <button class="btn btn-success btn-sm complete-btn"
                          data-task-id="<?= (int) str_replace('CHK-', '', $item['id']) ?>"
                          data-bs-toggle="modal" data-bs-target="#completeTaskModal">Completed
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                  <!-- Help Tickets -->
                  <?php foreach ($helperItems as $item): ?>
                    <tr class="hover-bg-light">
                      <td class="text-center"><input type="checkbox" /></td>
                      <td><strong><?= htmlspecialchars($item['id']) ?></strong></td>
                      <td>
                        <span class="text-muted"><?= htmlspecialchars($item['title']) ?></span>
                        <br><small class="text-secondary">By: <?= htmlspecialchars($item['assigned_by']) ?></small>
                      </td>
                      <td><span class="text-muted"><?= htmlspecialchars($item['date']) ?></span></td>
                      <td><span class="text-muted"><?= htmlspecialchars($item['status']) ?></span></td>
                      <td class="text-center">
                        <button class="btn btn-primary btn-sm me-1 note-help-btn"
                          data-task-id="<?= htmlspecialchars($item['id']) ?>"
                          data-bs-toggle="modal" data-bs-target="#noteHelpModal">Note
                        </button>

                        <button class="btn btn-success btn-sm complete-help-btn"
                          data-task-id="<?= htmlspecialchars($item['id']) ?>"
                          data-bs-toggle="modal" data-bs-target="#completeHelpModal">
                          Completed
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted">No tasks or tickets found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Comments Table -->
      <div id="commentsTableWrapper" class="d-none">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center bg-dark text-light">
            <h5 class="mb-0">💬 User Comments</h5>
            <button id="backToTasksBtn" class="btn btn-sm btn-outline-secondary bg-info text-light">
              ⬅ Back to Tasks
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped align-middle rounded-3 overflow-hidden">
                <thead class="table-primary">
                  <tr class="hover-bg-light">
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Task</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody id="commentsTableBody" class="table-light">
                  <!-- Comments injected dynamically -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- END Comments Table -->
    </div> <!-- END Main Content -->
  </div> <!-- END row -->
</div> <!-- END container-fluid -->

<!-- ======= CHECKLIST  CASE : ============== -->

<!-- Modal for Adding Note -->
<div class="modal fade" id="noteTaskModal" tabindex="-1" aria-labelledby="noteTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Added method + action -->
    <form id="noteTaskForm" method="POST" action="Task/submit_task.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="noteTaskModalLabel">Add Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_id" id="noteTaskId">

          <div class="mb-3">
            <label for="noteDescription" class="form-label">Description</label>
            <textarea class="form-control" id="noteDescription" name="description" rows="3" placeholder="Enter description"></textarea>
          </div>

          <div id="noteSuccessMessage" class="text-success fw-bold d-none text-center">
            ✅ Note added successfully!
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
      </div>
    </form>
  </div>
</div>



<!-- Modal for Completing Task -->
<div class="modal fade" id="completeTaskModal" tabindex="-1" aria-labelledby="completeTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Added method + action + enctype -->
    <form id="completeTaskForm" method="POST" action="Task/submit_task.php" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="completeTaskModalLabel">Mark Task as Completed</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_id" id="completeTaskId">

          <!-- Upload proof -->
          <div class="mb-3">
            <label for="proofFile" class="form-label">Upload Proof (image or file)</label>
            <input type="file" class="form-control" id="proofFile" name="proof_file" accept="image/*,.pdf,.doc,.docx">
          </div>

          <!-- Image preview -->
          <div id="proofPreview" class="mt-2 d-none">
            <p class="fw-bold">Preview:</p>
            <img id="previewImage" src="" class="img-fluid rounded border" style="max-height: 200px;" />
          </div>

          <!-- Success message -->
          <div id="completeSuccessMessage" class="text-success fw-bold d-none text-center mt-3">
            Task marked as completed successfully!
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Confirm Completion</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ======= HELP CASE : ============== -->

<!--  Helper Note -->
<div class="modal fade" id="noteHelpModal" tabindex="-1" aria-labelledby="noteHelpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="noteHelpForm" method="POST" action="Help/submit_help.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="noteHelpModalLabel">Add Note (Helper Task)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_id" id="noteHelpTaskId">

          <div class="mb-3">
            <label for="noteHelpDescription" class="form-label">Description</label>
            <textarea class="form-control" id="noteHelpDescription" name="description" rows="3" placeholder="Enter helper note"></textarea>
          </div>

          <div id="noteHelpSuccessMessage" class="text-success fw-bold d-none text-center">
            ✅ Note added successfully!
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!--  Completing Helper Task -->
<div class="modal fade" id="completeHelpModal" tabindex="-1" aria-labelledby="completeHelpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="completeHelpForm" method="POST" action="Help/submit_help.php" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="completeHelpModalLabel">Mark Helper Task as Completed</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_id" id="completeHelpTaskId">

          <!-- Upload proof -->
          <div class="mb-3">
            <label for="proofHelpFile" class="form-label">Upload Proof (image or file)</label>
            <input type="file" class="form-control" id="proofHelpFile" name="proof_file" accept="image/*,.pdf,.doc,.docx">
          </div>

          <!-- Image preview -->
          <div id="proofHelpPreview" class="mt-2 d-none">
            <p class="fw-bold">Preview:</p>
            <img id="previewHelpImage" src="" class="img-fluid rounded border" style="max-height: 200px;" />
          </div>

          <!-- Success message -->
          <div id="completeHelpSuccessMessage" class="text-success fw-bold d-none text-center mt-3">
            ✅ Helper task marked as completed successfully!
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Confirm Completion</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="asset/js/index.js"></script>

</body>
</html>
