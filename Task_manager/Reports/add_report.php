<?php
// Reports/add_report.php
// Lightweight, self-contained "Add Work Report" form.
// Place this file inside: Task_manager/Reports/add_report.php
// It expects get_project.php and submit_reports.php to be in the same folder.
include('../conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Add Work Report — Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/brands.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" type="text/css" href="../asset/css/add_report.css">
  
 
</head>
<body>
  <div class="card">
    <h2 class="text-center mb-4">Add Work Report</h2>

    <!-- NOTE: method/action are included as a progressive enhancement fallback -->
    <form id="reportForm" action="submit_reports.php" method="POST" enctype="multipart/form-data">
      <div class="form-container">

        <div class="form-left">
          <div class="mb-3">
            <label for="project_id">Project</label>
            <select id="project_id" name="project_id" class="form-control" required>
              <option value="">Loading projects...</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="user_id">User ID</label>
            <input type="number" id="user_id" name="user_id" class="form-control" placeholder="Enter user id" required>
          </div>

          <div class="mb-3">
            <label for="report_title">Report Title</label>
            <input type="text" id="report_title" name="report_title" class="form-control" placeholder="Report title" required>
          </div>

          <div class="mb-3">
            <label for="report_description">Description</label>
            <textarea id="report_description" name="report_description" class="form-control" rows="5" placeholder="Any details..."></textarea>
          </div>
        </div>

        <div class="form-right">
          <div class="mb-3">
            <label for="report_file">Report File (optional)</label>
            <input type="file" id="report_file" name="report_file" class="form-control">
          </div>

          <div class="mb-3">
            <label for="date_of_work">Date of Work</label>
            <input type="date" id="date_of_work" name="date_of_work" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="hours_spent">Hours Spent</label>
            <input type="number" id="hours_spent" name="hours_spent" class="form-control" step="0.1" min="0" required>
          </div>

          <div class="mb-3">
            <label for="task_status">Task Status</label>
            <select id="task_status" name="task_status" class="form-control">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>

      </div><!-- /.form-container -->

      <div class="text-end mt-3">
        <button type="submit" class="btn btn-submit px-4 py-2"><i class="fa-solid fa-paper-plane"></i>&nbsp;Submit Report</button>
      </div>
    </form>

    <div id="message" class="mt-3"></div>
  </div>

   <script src="../asset/js/reports.js"></script>
</body>
</html>