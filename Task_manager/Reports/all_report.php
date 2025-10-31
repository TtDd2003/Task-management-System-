<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../asset/css/report.css">
</head>
<body>

  <!-- Hamburger Icon -->
  <div class="hamburger" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </div>

  <!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo text-center py-3">
    <img src="../asset/img/logo.png" class="img-fluid logo-img" alt="Logo">
  </div>
  <a class="nav-link" href="../index.php"><i class="fas fa-home me-2"></i> Home</a>
  <a class="nav-link" href="../User/user_profile.php"><i class="fa-solid fa-user"></i> User </a>
  <a class="nav-link" href="#"><i class="fas fa-chart-pie me-2"></i> Reports</a>
  <a class="nav-link" href="add_report.php"><i class="fas fa-plus me-2"></i> Add</a>
  <a class="nav-link" href="#"><i class="fas fa-cog me-2"></i> Settings</a>
</div>

  <!-- Main Content -->
  <div class="content">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card  p-4">
          <h5>Total Projects</h5>
          <h2>182</h2>
          <button class="btn btn-light text-white bg-danger btn-sm mt-2 rounded-pill">Add new project</button>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card  p-4">
          <h5>Team Size</h5>
          <h2>14</h2>
          <button class="btn btn-light text-white bg-success btn-sm mt-2 rounded-pill">Add new members</button>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-4">
          <h5>Project Progress</h5>
          <canvas id="progressChart" height="120"></canvas>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-4">
          <h5>Total Working Hours</h5>
          <small class="text-muted">37 hours this week</small>
          <canvas id="hoursChart" height="120"></canvas>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-4">
          <h5>Project Revenue</h5>
          <h3>+ $12,856.14</h3>
          <small class="text-muted">Avg. $3,000/month</small>
          <canvas id="revenueChart" height="120"></canvas>
        </div>
      </div>

      <div class="col-12">
        <div class="card p-4">
          <h5>Project Categories</h5>
          <div class="row text-center g-3">
            <div class="col-md-3">
              <div class="category-card" style="background-color:#fcd6af">
                <div class="category-icon"><i class="fas fa-chart-bar text-warning"></i></div>
                Research
              </div>
            </div>
            <div class="col-md-3">
              <div class="category-card" style="background-color:#b7e5ff">
                <div class="category-icon"><i class="fas fa-photo-video text-info"></i></div>
                Marketing
              </div>
            </div>
            <div class="col-md-3">
              <div class="category-card" style="background-color:#fef6c2">
                <div class="category-icon"><i class="fas fa-cogs text-warning"></i></div>
                Operations
              </div>
            </div>
            <div class="col-md-3">
              <div class="category-card" style="background-color:#d4f9d4">
                <div class="category-icon"><i class="fas fa-smile text-success"></i></div>
                Customers
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const progressChart = new Chart(document.getElementById('progressChart'), {
      type: 'bar',
      data: {
        labels: ['Feb', 'Mar', 'Apr'],
        datasets: [
          { label: 'Project 1', data: [10, 30, 60], backgroundColor: 'rgba(255, 99, 132, 0.6)' },
          { label: 'Project 2', data: [20, 50, 70], backgroundColor: 'rgba(54, 162, 235, 0.6)' },
          { label: 'Project 3', data: [30, 60, 90], backgroundColor: 'rgba(75, 192, 192, 0.6)' }
        ]
      },
      options: {
        indexAxis: 'y',
        plugins: { title: { display: true, text: 'Gantt-like Progress Representation' } },
        responsive: true
      }
    });

    const hoursChart = new Chart(document.getElementById('hoursChart'), {
      type: 'bar',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Hours Worked',
          data: [6, 7, 8, 7, 6, 3, 0],
          backgroundColor: ['#FF6384','#FF9F40','#FFCD56','#4BC0C0','#36A2EB','#9966FF','#C9CBCF']
        }]
      },
      options: {
        scales: { y: { beginAtZero: true, max: 10 } }
      }
    });

    const revenueChart = new Chart(document.getElementById('revenueChart'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
        datasets: [{
          label: 'Revenue ($)',
          data: [1200, 1800, 2200, 2500, 3200, 2800, 3400, 3900],
          backgroundColor: 'rgba(153, 102, 255, 0.7)'
        }]
      },
      options: {
        indexAxis: 'x',
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
