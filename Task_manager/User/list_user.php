<?php
include('../conn.php');

// Pagination setup
$limit = 5; // number of records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Optional: Filter conditions
$where = [];
if (!empty($_GET['username'])) {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    $where[] = "username LIKE '%$username%'";
}
if (!empty($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $where[] = "(first_name LIKE '%$name%' OR last_name LIKE '%$name%')";
}
if (!empty($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $where[] = "email LIKE '%$email%'";
}
if (!empty($_GET['user_code'])) {
    $user_code = mysqli_real_escape_string($conn, $_GET['user_code']);
    $where[] = "user_code LIKE '%$user_code%'";
}

// Combine WHERE conditions
$whereSql = '';
if (count($where) > 0) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);   //implode every GET[''] with AND //
}

// Main paginated query
$query = " SELECT u.id, u.first_name, u.last_name, u.email, u.user_code, u.created_by, i.username, i.phone_number
  FROM users AS u LEFT JOIN info_user AS i ON u.id = i.user_id $whereSql ORDER BY u.created_at ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Count total records for pagination
$countQuery = "SELECT COUNT(*) AS total FROM users AS u LEFT JOIN info_user AS i ON u.id = i.user_id $whereSql ";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title> User List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <!-- css styles-->
  <link rel="stylesheet" type="text/css" href="../asset/css/user_list.css">

</head>
<body>
   <!-- ====== Filter Bar ===== -->
  <form  id="filterForm" class="navbar bg-white p-3 rounded shadow-sm mb-4 col-11" method="get">
    <div class="container-fluid row g-3 align-items-center ">

        <div class="col-md-3">
          <input type="text" name="username" class="form-control" placeholder="Search by Username"
            value="<?php echo htmlspecialchars($_GET['username'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <input type="text" name="name" class="form-control" placeholder="Search by Name"
            value="<?php echo htmlspecialchars($_GET['name'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <input type="email" name="email" class="form-control" placeholder="Search by Email"
            value="<?php echo htmlspecialchars($_GET['email'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <input type="text" name="user_code" class="form-control" placeholder="Search by code"
            value="<?php echo htmlspecialchars($_GET['user_code'] ?? '') ?>">
        </div>

          <div class="col-md-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2">
              <i class="fas fa-search me-1"></i> Filter
            </button>

           <button type="button" class="btn btn-success me-2" onclick="resetFilter()">
              <i class="fa-solid fa-rotate"></i> Reset
          </button>

            <!-- add new user --->
             <a href="user_entry.php" class="btn btn-warning me-2">
                <i class="fa-solid fa-plus"></i> New
              </a>
          </div>

    </div>
  </form>

<h1 class="text-center">User List</h1>

<div class="container-fluid row g-3 align-items-center col-11 mx-auto">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Username</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Created By</th>
          <th>Actions</th>
        </tr>
      </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($result) > 0):
          $i = 1;
          while ($row = mysqli_fetch_assoc($result)):
      ?>
        <tr>
          <td data-label="#"><?php echo $i++; ?></td>
          <td data-label="User Code"><?php echo htmlspecialchars($row['user_code']);  ?></td>
          <td data-label="Username"><?php echo htmlspecialchars($row['username']);  ?></td>
          <td data-label="First Name"><?php echo htmlspecialchars($row['first_name']); ?></td>
          <td data-label="Last Name"><?php echo htmlspecialchars($row['last_name']); ?></td>
          <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
          <td data-label="Phone"><?php echo htmlspecialchars($row['phone_number']); ?></td>
          <td data-label="Created By"><?php echo htmlspecialchars($row['created_by']); ?></td>
          <td data-label="Actions" class="actions">

            <!-- = edit button === -->
            <button class="action-btn edit btn btn-sm " title="Edit User">
                <a href="?id=<?= $row['id']; ?>" class="btn btn-sm editUserBtn" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="fa-solid fa-pen-to-square text-info"></i></a>
            </button>
              <!-- = delete  button === -->
              <button class="action-btn delete btn btn-sm " title="Delete User" data-id="<?= $row['id']; ?>">
                  <i class="fa-solid fa-trash"></i>
              </button>

          </td>
        </tr>
      <?php
          endwhile;
      else:
      ?>
      <tr>
        <td colspan="9" style="text-align:center;">No users found.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- ====== pagination div bar ===== --> 

  <div class="col-11 mb-4 p-2 m-3">
    <nav>
      <ul class="pagination justify-content-end">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Prev</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
<!-- ====== pagination end  ===== --> 


<!-- ========= modal of updating ======= -->

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="editUserForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-2">
          <label>Username</label>
          <input type="text" name="username" id="edit-username" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>First Name</label>
          <input type="text" name="first_name" id="edit-firstname" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Last Name</label>
          <input type="text" name="last_name" id="edit-lastname" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Email</label>
          <input type="email" name="email" id="edit-email" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Phone</label>
          <input type="text" name="phone_number" id="edit-phone" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../asset/js/user.js"></script>


</body>
</html>
