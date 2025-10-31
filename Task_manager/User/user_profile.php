<?php
session_start();
include ('../conn.php');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: login.php');
    exit();
}

// here select that user whose id , data comes from post--- 
$sql = "SELECT u.first_name, u.last_name, u.email, i.username, i.phone_number, i.gender, i.date_of_birth, i.language, i.country,
        i.alternative_email_2   ,i.profile_picture , i.bio FROM users AS u LEFT JOIN info_user AS i ON u.id = i.user_id 
        WHERE u.id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// here stores all data in session--
$_SESSION['first_name'] =$user['first_name'];
$_SESSION['last_name'] =$user['last_name'];
$_SESSION['email'] =$user['email'];
$_SESSION['username'] =$user['username'];
$_SESSION['date_of_birth'] =$user['date_of_birth'];
$_SESSION['phone_number'] =$user['phone_number'];
$_SESSION['gender'] =$user['gender'];
$_SESSION['language'] =$user['language'];
$_SESSION['country'] =$user['country'];
$_SESSION['alternative_email_2'] =$user['alternative_email_2'];
$_SESSION['profile_picture'] =$user['profile_picture'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile Setup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.css"> -->
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/brands.min.css" integrity="sha512-mXqwRsOznG7CS37KA7CLR1Fc72gfOgp7r8xaVdBKoBKhitcKI/mK+IamtZUf+FAkufXOvVTESu9lPsoQc+kFxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 <link rel="stylesheet" type="text/css" href="../asset/css/profile.css">
</head>
<body>

  <!-- Sidebar -->
<div id="sidebar" class="sidebar text-center col-3 d-md-block shadow-lg rounded-tr-3xl rounded-br-3xl  
                 backdrop-blur-sm border border-blue-100 max-w-3xl mx-auto" style="background-color: #3B82F6;">


    <div class="flex flex-col items-center justify-center h-full space-y-10 pt-12 sidebar-inner ">
        <!-- Home -->
        <a href="../index.php">
          <button aria-label="Dashboard" class=" rounded-lg p-3 text-blue-600 cursor-pointer" title="Dashboard" style="background-color:'#16E2F5;'">
            <i class="fas fa-house"></i>
          </button>
        </a>

        <!-- User -->
         <a href=""><button aria-label="User" class=" rounded-lg p-3 text-blue-600 cursor-pointer" title="User" style="background-color:'#16E2F5;'">
          <i class="fas fa-user"></i>
        </button></a>

        <!-- Messages -->
         <a href=""><button aria-label="Messages" class=" rounded-lg p-3 text-blue-600 cursor-pointer" title="Messages" style="background-color:'#16E2F5;'">
          <i class="fas fa-envelope"></i>
        </button></a>

        <!-- Settings -->
        <a href="">  <button aria-label="Settings" class=" rounded-lg p-3 text-blue-600 cursor-pointer" title="Settings" style="background-color:'#16E2F5;'">
          <i class="fas fa-cog"></i>
        </button></a>
    </div>

</div>


<!-- Hamburger Icon for Small Screens -->
<div class="d-md-none p-3">
  <button id="toggleSidebarBtn" class="btn btn-outline-primary d-md-none" style="position: fixed; top: 15px; left: 15px; z-index: 1001;">
  <i class="bi bi-list"></i>
</button>
</div>


  <!-- Main Content -->
  <div class="main max-w-6xl mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-3  bg-gradient-to-r from-blue-300 via-blue-100 to-yellow-100 rounded-t-3xl py-4 px-6 mb-8 shadow-inner ">
      
         <h2 class="fw-bold text-dark">Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></h2>

      <div class="d-flex align-items-center">

      <div class="relative w-full">
          <input  type="search"  placeholder="Search"  class="w-full rounded-full border border-gray-300 py-2 pl-10 pr-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
          />
          <svg class="w-5 h-5 text-gray-400 absolute top-2.5 left-3 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
            viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7" />
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
        </div>

        <button aria-label="Notifications" class="relative p-1 rounded-lg hover:bg-gray-200 text-gray-700 transition" title="Notifications">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" id='notifications'>
            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 0 0-5-5.917V5a2 2 0 1 0-4 0v.083A6 6 0 0 0 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 0 1-6 0v-1m6 0H9"/>
          </svg>
         
        </button>
      </div>
    </div>

    <!-- Profile Form Card -->
    <div class="profile-card max-w-6xl mx-auto">
      <form id="profileForm" method="POST" action="save_profile.php" enctype="multipart/form-data">

        <div class="row g-4 ">

          <div class="col-md-4 text-center  bg-gradient-to-l from-violet-300 via-bluw-100 to-yellow-100">
              <div class="profile-img-placeholder text-center " id="previewProfileImg"
                    style="position: relative; width: 150px; height: 150px; margin: 0 auto;">

                      <?php
                        // Prefer the DB value directly from $user, fallback to default image
                        $profilePicture = $user['profile_picture'] ?? '';
                        $imagePath = (!empty($profilePicture) && file_exists("../User/" . $profilePicture))
                                     ? "../User/" . htmlspecialchars($profilePicture)
                                     : "../assets/default-avatar.png";
                      ?>

                      <!-- Profile Image -->
                      <img src="<?= $imagePath ?>" alt="Profile Picture"
                           style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #ddd;">

                      <!-- Hidden File Input -->
                      <input type="file" name="profile_picture" id="profilePicInput" accept="image/*" style="display: none;">

                      <!-- Clickable Pencil Icon -->
                      <label for="profilePicInput"
                             style="position: absolute; bottom: 5px; right: 5px; background: #fff; border-radius: 50%;
                                    padding: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.2); cursor: pointer;">
                        <i class="bi bi-pencil-fill"></i>
                      </label>

                      <p class="text-muted mt-2  mb-4">Click icon to change</p>
                </div>


               <div class="m-3 p-3 "><?= htmlspecialchars($_SESSION['email']) ?></div>

           <!-- BIO area (gradient background like you had) -->
              <div class="p-2 bg-gradient-to-r from-red-300 via-green-100 to-pink-100 rounded mb-3">
               <div class="d-flex align-items-center justify-content-between border">

                  <!-- Display view -->
                  <div id="bioView" class="<?= empty($user['bio']) ? 'd-none' : 'w-100' ?>" class=' bg-dark'>
                  <h2 id="bioText" class="border ">
                      <?= !empty($user['bio']) ? htmlspecialchars($user['bio']) : '' ?>
                    </h2>
                  </div>

                  <div class="w-100">
                    <textarea id="bioInput" name="bio" rows="3" class="form-control <?= empty($user['bio']) ? '' : 'd-none' ?>"
                              placeholder="Add your bio.">
                              <?= htmlspecialchars($user['bio'] ?? '') ?>                                
                    </textarea>
                  </div>

                  <!-- Edit / Save button -->
                  <div class="ms-2 border">
                    <button type="button" id="editBioBtn" class="btn btn-sm btn-outline-secondary" aria-label="Edit bio">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            
            
          </div>

          <div class="col-md-7  ml-7 col-10 border ">

            <div class="row   col-12 mx-auto p-2 ">
              <!-- gender -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6  w-full ">
                  <!-- Gender -->
                  <div>
                    <label for="gender" class="block text-gray-700 font-medium mb-2">Gender</label>
                    <select id="gender" name="gender" class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                      <option value="" disabled <?= empty($_SESSION['gender']) ? 'selected' : '' ?>>Select Gender</option>
                      <option <?= $_SESSION['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                      <option <?= $_SESSION['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                      <option <?= $_SESSION['gender'] == 'Non-binary' ? 'selected' : '' ?>>Non-binary</option>
                      <option <?= $_SESSION['gender'] == 'Prefer not to say' ? 'selected' : '' ?>>Prefer not to say</option>
                    </select>
        
                  </div>

                  <!-- Date of Birth -->
                  <div>
                    <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                    <input type="date" name="dob" class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required value="<?= htmlspecialchars($_SESSION['date_of_birth'] ?? '') ?>">
                  </div>

                  <!-- Username -->
                  <div>
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <div class="mt-1 relative">
                      <input id="username" name="username" type="text" required class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" maxlength="20" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" 
                        placeholder="Enter Username" />
                    </div>
                  </div>

                  <!-- Language -->
                  <div>
                    <label for="language" class="block text-gray-700 font-medium mb-2">Language</label>
                    <select id="language" name="language" class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                      <option value="" disabled <?= empty($_SESSION['language']) ? 'selected' : '' ?>>Select Language</option>
                      <option <?= $_SESSION['language'] == 'English' ? 'selected' : '' ?>>English</option>
                      <option <?= $_SESSION['language'] == 'Spanish' ? 'selected' : '' ?>>Spanish</option>
                      <option <?= $_SESSION['language'] == 'French' ? 'selected' : '' ?>>French</option>
                      <option <?= $_SESSION['language'] == 'Chinese' ? 'selected' : '' ?>>Chinese</option>
                      <option <?= $_SESSION['language'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                     
                  </div>

                  <!-- Emergency Contact -->
                  <div>
                    <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <div class="mt-1 relative">
                      <input type="tel" name="phone" class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="+91 1234567890"  pattern="^\d{10}$" maxlength="10" required 
                      value="<?= htmlspecialchars($_SESSION['phone_number'] ?? '') ?>"/>
                      
                    </div>
                  </div>

                  <!-- Country -->
                  <div>
                    <label class="block text-gray-700 font-medium mb-2">Country</label>
                    <input type="text" name="country" class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Optional" value="<?= htmlspecialchars($_SESSION['country'] ?? '') ?>">
                   
                  </div>

                </div><!-- grid end ===-->


              <div class="row mt-3">
                  <div class="col-md-6">
                    <label class="form-check-label">Email notifications</label>
                        <div class="form-check form-switch">
                          <input class="form-check-input switch" type="checkbox" name="email_notify" checked>
                        </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-check-label">SMS notifications</label>
                        <div class="form-check form-switch">
                          <input class="form-check-input switch" type="checkbox"  name="sms_notify">
                        </div>
                  </div>
              </div>

              <!--  ========  ADDITIONAL  Email Addresses Section  ===== -->
                <div class="mt-10 max-w-lg">
                  <h3 class="font-semibold text-gray-900 mb-4">My email Address</h3>
                  <ul class="space-y-4">
                    <li class="flex items-center gap-4">
                      <span class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-200 text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                          <path d="M4 4h16v16H4z"/>
                          <polyline points="22,6 12,13 2,6"/>
                        </svg>
                      </span>
                      <div>
                        <p class="text-gray-900 font-semibold"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
                        <p class="text-gray-400 text-sm">1 month ago</p>
                      </div>
                    </li>
                  </ul>

                  <!-- == email alternative == -->
                 <div id="emailFieldContainer" class="mt-4">
                    <?php if (!empty($_SESSION['alternative_email_2'])): ?>
                        <label for="alternative_email" class="block text-gray-700 font-medium mb-2">Alternative Email</label>
                            <input type="email"  name="alternative_email"  id="alternative_email"  class="w-full rounded-md border border-gray-200 bg-gray-50 py-3 px-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter alternative email"
                           value="<?= htmlspecialchars($_SESSION['alternative_email_2']) ?>" />
                    <?php else: ?>

                    <button type="button" class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium 
                        transition" id="addEmailBtn"> + Add Email Address
                    </button>
                    <?php endif; ?>
                    
                    </div>
                </div>

                <!--  ==== email end ==== -->

            </div>
            <div class="text-end mt-4">
              <button type="submit" name="saveInfo" class="btn btn-primary">Update Profile</button>
            </div>

          </div>

        </div>
      </form>
    </div>
  </div>


<!-- Notification Panel -->
<div id="notificationPanel" class="hidden container mt-4 max-w-6xl mx-auto">
  <div class="card p-4 shadow-sm border rounded-4" style="background: linear-gradient(135deg, #38bdf8, #60a5fa, #93c5fd);">
    <h5 class="mb-4 fw-bold text-white">Notifications</h5>
    <div id="notificationList" class="notification-list">
        <!-- JS will insert items here -->
    </div>
  </div>
</div>


 <script src="https://cdn.tailwindcss.com"></script>
 <script src='../asset/js/profile.js'></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
