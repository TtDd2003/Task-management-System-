<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notifications - Tri Tech Task Manager</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(135deg, #f8fafc, #e0e7ff);
      font-family: "Segoe UI", sans-serif;
    }

    /* Header (same as your version) */
    .header {
      background-color: #111827;
      color: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.6rem 1.5rem;
    }

    .logo-img {
      max-height: 50px;
      width: auto;
      height: auto;
      object-fit: contain;
    }

    @media (max-width: 768px) {
      .logo-img {
        max-height: 38px;
      }
    }

    .nav-icons a {
      color: #cbd5e1;
      font-size: 1.2rem;
      margin-left: 1.2rem;
      transition: color 0.2s;
    }

    .nav-icons a:hover {
      color: #fff;
    }

    /* Main container */
    .notification-wrapper {
      max-width: 700px;
      margin: 60px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .notification-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 25px;
      border-bottom: 1px solid #e5e7eb;
    }

    .notification-header h4 {
      font-weight: 700;
      margin: 0;
      font-size: 1.25rem;
      color: #111827;
    }

    .notification-header i {
      color: #0d6efd;
      font-size: 1.3rem;
    }

    .notification-item {
      display: flex;
      align-items: flex-start;
      padding: 18px 25px;
      border-bottom: 1px solid #f1f5f9;
      transition: background-color 0.2s;
    }

    .notification-item:hover {
      background-color: #f8fafc;
    }

    .notification-item img {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }

    .notification-content {
      flex: 1;
    }

    .notification-content strong {
      color: #0d6efd;
      font-weight: 600;
    }

    .notification-content p {
      margin: 0;
      color: #374151;
      font-size: 0.95rem;
    }

    .notification-time {
      font-size: 0.8rem;
      color: #6b7280;
      white-space: nowrap;
    }

    .view-all {
      text-align: center;
      padding: 15px;
      font-weight: 500;
      color: #0d6efd;
      cursor: pointer;
      transition: background 0.2s;
    }

    .view-all:hover {
      background: #f1f5f9;
      color: #0b5ed7;
    }

  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <div class="d-flex align-items-center">
      <img src="asset/img/logo.PNG" alt="Logo" class="logo-img" />
    </div>
    <div class="nav-icons">
      <a href="index.php"><i class="fa-solid fa-home"></i></a>
      <a href="User/user_profile.php"><i class="fa-solid fa-user"></i></a>
      <a href="#"><i class="fa-solid fa-gear"></i></a>
    </div>
  </div>

  <!-- Notification Section -->
  <div class="notification-wrapper">
    <div class="notification-header">
      <h4><i class="fa-regular fa-bell me-2"></i>Notifications</h4>
      <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <!-- Notification Items -->
    <div class="notification-item">
      <img src="User/uploads/68c998c6dae10_dho.jpg" alt="User" />
      <div class="notification-content">
        <p><strong>Kate Young</strong> commented on your task.</p>
        <p>“Great work on the <strong>Website Revamp</strong> design!”</p>
      </div>
      <div class="notification-time">5 mins ago</div>
    </div>

    <div class="notification-item">
      <img src="User/uploads/68cd786a3ed40_sanjana.jpg" alt="User" />
      <div class="notification-content">
        <p><strong>Brandon Newman</strong> liked your report submission.</p>
        <p>“Excellent progress on <strong>UI/UX Sprint</strong>!”</p>
      </div>
      <div class="notification-time">25 mins ago</div>
    </div>

    <div class="notification-item">
      <img src="User/uploads/68cd7a8f6a5b1_pitajiii.jpg" alt="User" />
      <div class="notification-content">
        <p><strong>Dave Wood</strong> assigned you a new checklist.</p>
        <p><strong>Backend API Integration</strong> task added to your list.</p>
      </div>
      <div class="notification-time">2 hrs ago</div>
    </div>

    <div class="notification-item">
      <img src="User/uploads/68cd7772c99eb_sukuji.jpg" alt="User" />
      <div class="notification-content">
        <p><strong>Anna Lee</strong> commented on your progress.</p>
        <p>“Keep up the amazing pace on <strong>Mobile App Beta</strong>!”</p>
      </div>
      <div class="notification-time">1 day ago</div>
    </div>

    <div class="view-all">See all incoming activity</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
