<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../asset/css/add_project.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="header">
                    <h1><i class="fas fa-project-diagram me-2"></i>Add New Project</h1>
                    <p>Fill in the details below to create a new project</p>
                </div>

                <div class="theme-selector">
                    <button class="theme-btn" style="background-color: #4e73df; color: white;" onclick="setTheme('blue')">Blue Theme</button>
                    <button class="theme-btn" style="background-color: #1cc88a; color: white;" onclick="setTheme('green')">Green Theme</button>
                    <button class="theme-btn" style="background-color: #f6c23e; color: white;" onclick="setTheme('yellow')">Yellow Theme</button>
                    <button class="theme-btn" style="background-color: #e74a3b; color: white;" onclick="setTheme('red')">Red Theme</button>
                </div>

                <div class="card p-4 p-md-5">
                    <form id="projectForm" action="submit_project.php" method="POST">
                        <div class="mb-3 animated-field" style="animation-delay: 0.1s">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="projectName"  name="project_name" placeholder="Enter project name" required>
                        </div>

                        <div class="mb-3 animated-field" style="animation-delay: 0.2s">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description"  name="description" rows="4" placeholder="Enter project description"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.3s">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" required/>
                            </div>
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.4s">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.5s">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration"placeholder="e.g., 3 months">
                            </div>
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.6s">
                                <label for="revenue" class="form-label">Revenue ($)</label>
                                <input type="number" class="form-control" id="revenue" name="revenue"placeholder="Enter revenue amount">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.7s">
                                <label for="teamSize" class="form-label">Team Size</label>
                                <input type="number" class="form-control" id="teamSize"  name="team_size"placeholder="Number of team members">
                            </div>
                            <div class="col-md-6 mb-3 animated-field" style="animation-delay: 0.8s">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="working">Working</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="animated-field" style="animation-delay: 0.9s">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Add Project
                            </button>
                        </div>
                    </form>

                    <div class="success-message" id="successMessage">
                        <i class="fas fa-check-circle me-2"></i> Project added successfully!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../asset/js/project.js"></script>
</body>
</html>
