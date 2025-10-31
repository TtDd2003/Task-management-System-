
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Task Assignment</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Load Bootstrap first -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- Then load your custom styles -->
    <link rel="stylesheet" href="../asset/css/task.css">

    
</head>
<body>
    <div class="container py-5 ">
        <div class="row justify-content-center ">
            <div class="col-xl-8 col-lg-10 col-md-10">
                <div class="card ">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h4 class="m-0 font-weight-bold text-white ">
                            <i class="fas fa-tasks me-2"></i>Task Assignment
                        </h4>
                        <div class="text-white">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <span id="current-date"></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="taskAssignmentForm" novalidate>
                        <!-- Assignee Selection -->
                        <div class="mb-4">
                            <div class="floating-label-group">
                                <input type="text" class="form-control" name="assignee" id="assignee" required placeholder=" " />
                                <label class="floating-label">Enter Assignee Name</label>
                            </div>

                            <div id="assigneePreview" class="d-none mt-3 align-items-center">
                                <img src="" alt="Selected user's profile picture" class="assigned-user-avatar">
                                <div>
                                    <h6 class="mb-0" id="assigneeName"></h6>
                                    <small class="text-muted" id="assigneeRole"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Task Title -->
                        <div class="mb-4">
                            <div class="floating-label-group">
                                <input type="text" class="form-control" name="taskTitle" id="taskTitle" placeholder=" " required>
                                <label class="floating-label">Task Title</label>
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="mb-4">
                            <div class="floating-label-group">
                                <textarea class="form-control" name="taskDescription" id="taskDescription" rows="4" placeholder=" " required></textarea>
                                <label class="floating-label">Task Description</label>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Priority Level -->
                            <div class="col-md-6 mb-4">
                                <div class="floating-label-group">
                                    <select class="form-select" name="priority" id="priority" required>
                                        <option value="" selected disabled></option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                    <label class="floating-label">Priority Level</label>
                                </div>
                                <div class="mt-2" id="priorityIndicator">
                                    <span class="badge d-none priority-high"><i class="fas fa-exclamation-circle me-1"></i>High</span>
                                    <span class="badge d-none priority-medium"><i class="fas fa-exclamation-triangle me-1"></i>Medium</span>
                                    <span class="badge d-none priority-low"><i class="fas fa-check-circle me-1"></i>Low</span>
                                </div>
                            </div>

                            <!-- Due Date -->
                            <div class="col-md-6 mb-4">
                                <div class="floating-label-group">
                                    <input type="date" class="form-control" name="dueDate" id="dueDate" min="" required>
                                    <label class="floating-label">Due Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Project Category -->
                        <div class="mb-4">
                            <div class="floating-label-group">
                                <select class="form-select" name="project" id="project" required>
                                    <option value="" selected disabled></option>
                                    <option value="web">Website Redesign</option>
                                    <option value="mobile">Mobile App Development</option>
                                    <option value="marketing">Marketing Campaign</option>
                                    <option value="backend">Backend API</option>
                                    <option value="ui">UI/UX Design</option>
                                </select>
                                <label class="floating-label">Project/Category</label>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-4">
                            <div class="floating-label-group">
                                <textarea class="form-control" name="additionalNotes" id="additionalNotes" rows="2" placeholder=" "></textarea>
                                <label class="floating-label">Additional Notes (Optional)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="notifyUser" id="notifyUser">
                                <label class="form-check-label" for="notifyUser">
                                    Notify user via email
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                <span id="submitText">Assign Task</span>
                                <span class="loading spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>

                    <!-- CSV Upload Section -->
                    <div class="csv-upload-container mt-4  ">
                      <h2 class="h5 mb-3">Bulk Task Upload (CSV)</h2>
                      <form id="csvUploadForm" enctype="multipart/form-data">
                          <div class="csv-upload-box">
                            <label for="csvFile" class="csv-label">
                              <span>📂 Choose CSV File</span>
                              <input type="file" id="csvFile" name="csvFile" accept=".csv" required />
                            </label>
                            <button type="submit" class="btn btn-success mt-3">Upload Tasks</button>
                          </div>
                          <small class="text-muted d-block mt-2">
                            CSV format: <code>Assignee, Title, Description, Priority, DueDate, Category, Notes</code>
                          </small>
                        </form>

                    </div>

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

