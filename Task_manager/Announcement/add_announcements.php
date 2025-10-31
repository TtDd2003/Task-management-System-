<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Announcements - Project Task Management System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../asset/css/style_announcements.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
          .logo-img {
            max-width: 120px;
            width: 100%;
            height: auto;
            display: block;
        }

        .outer-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .outer-card header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-img {
            max-width: 120px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 10px auto;
        }

        .form-card, .announcement-list-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 15px 10px;
            background-color: #343a40;
            color: #fff;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="outer-card">
        <!-- Header -->
        
        <header class="d-flex flex-column flex-lg-row align-items-center justify-content-center mb-4">
    <img src="../asset/img/logo.PNG" alt="Logo" class="logo-img img-fluid me-lg-3 mb-3 mb-lg-0" />
    <h1 class="m-0">Announcements Board</h1>
</header>


        <!-- Form Card -->
        <div class="form-card">
            <h2>Create New Announcement</h2>
            <form id="announcementForm" novalidate>
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter announcement title" required />
                    <div class="invalid-feedback">Please enter a title.</div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Message</label>
                    <textarea id="message" name="message" rows="4" class="form-control" placeholder="Enter the announcement details" required></textarea>
                    <div class="invalid-feedback">Please enter the announcement message.</div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label fw-semibold">Category</label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="general" selected>General</option>
                        <option value="urgent">Urgent</option>
                        <option value="project">Project Update</option>
                        <option value="meeting">Meeting Notice</option>
                    </select>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
                <div class="mb-4">
                    <label for="date" class="form-label fw-semibold">Date (Optional)</label>
                    <input type="date" id="date" name="date" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary w-100">Post Announcement</button>
            </form>
        </div>

        <!-- Recent Announcements Card -->
        <div class="announcement-list-card">
            <h2 class="h5 mb-3">Recent Announcements</h2>
            <div id="announcementsContainer"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Your Company Name. All rights reserved.
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../asset/js/announcements.js"></script>
</body>
</html>
