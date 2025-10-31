<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../conn.php');

if (!isset($_SESSION['user_id'])) {
    // If AJAX request expect JSON, otherwise a simple message
    if (isset($_POST['bio_only'])) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    } else {
        echo "User not logged in.";
    }
    exit;
}
$user_id = (int) $_SESSION['user_id'];

// === QUICK AJAX BIO-SAVE PATH ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio_only'])) {
    header('Content-Type: application/json');

    $bio_raw = trim($_POST['bio'] ?? '');
    // Optional length validation
    if (mb_strlen($bio_raw) > 2000) {
        echo json_encode(['status' => 'error', 'message' => 'Bio too long (max 2000 chars).']);
        exit;
    }

    $bioEsc = $conn->real_escape_string($bio_raw);

    $sql = "UPDATE info_user SET bio = '$bioEsc' WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'ok', 'bio' => $bio_raw]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    $conn->close();
    exit;
}

// === FULL FORM SUBMIT PATH ===
// Collect and sanitize inputs
$username = trim($_POST['username'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$gender   = trim($_POST['gender'] ?? '');
$dob      = trim($_POST['dob'] ?? '');
$lang     = trim($_POST['language'] ?? '');
$country  = trim($_POST['country'] ?? '');
$email_notify = isset($_POST['email_notify']) ? 1 : 0;
$sms_notify   = isset($_POST['sms_notify']) ? 1 : 0;
$alt_raw      = trim($_POST['alternative_email'] ?? '');
$bio_raw      = trim($_POST['bio'] ?? '');

// Validate inputs
$errors = [];
if ($username === '' || strlen($username) > 20) {
    $errors[] = "Username is required and must be 20 characters or fewer.";
}
if (!preg_match('/^\d{10}$/', $phone)) {
    $errors[] = "Phone number must be exactly 10 digits.";
}
if ($alt_raw !== '' && !filter_var($alt_raw, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Alternative email must be a valid email address.";
}
if (mb_strlen($bio_raw) > 2000) {
    $errors[] = "Bio must be 2000 characters or fewer.";
}

if ($errors) {
    echo implode("\n", $errors);
    exit;
}

// Escape sanitized data
$usernameEsc = $conn->real_escape_string($username);
$phoneEsc    = $conn->real_escape_string($phone);
$genderEsc   = $conn->real_escape_string($gender);
$dobEsc      = $conn->real_escape_string($dob);
$langEsc     = $conn->real_escape_string($lang);
$countryEsc  = $conn->real_escape_string($country);
$alt_email   = $alt_raw !== '' ? "'" . $conn->real_escape_string($alt_raw) . "'" : "NULL";
$bioEsc      = $conn->real_escape_string($bio_raw);

// Profile picture upload (optional)
$profile_picture = "NULL";
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $uploadPath)) {
        // Escape and wrap for SQL
        $profile_picture = "'" . $conn->real_escape_string($uploadPath) . "'";
    } else {
        echo "Failed to upload image.";
        exit;
    }
}

// UPSERT (INSERT ... ON DUPLICATE KEY UPDATE)
$sql = "
INSERT INTO info_user (
    user_id, username, gender, date_of_birth, profile_picture,
    language, phone_number, country,
    email_notifications, sms_notifications, alternative_email_2,
    bio
) VALUES (
    $user_id, '$usernameEsc', '$genderEsc', '$dobEsc', $profile_picture,
    '$langEsc', '$phoneEsc', '$countryEsc',
    $email_notify, $sms_notify, $alt_email,
    '$bioEsc'
)
ON DUPLICATE KEY UPDATE
    username = VALUES(username),
    gender = VALUES(gender),
    date_of_birth = VALUES(date_of_birth),
    profile_picture = COALESCE(VALUES(profile_picture), profile_picture),
    language = VALUES(language),
    phone_number = VALUES(phone_number),
    country = VALUES(country),
    email_notifications = VALUES(email_notifications),
    sms_notifications = VALUES(sms_notifications),
    alternative_email_2 = VALUES(alternative_email_2),
    bio = VALUES(bio)
";

if ($conn->query($sql) === TRUE) {
    // same success UI you had
    echo "
    <style>
        .custom-alert {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #e6fffa;
            color: #0f5132;
            padding: 20px 30px;
            border: 2px solid #0dcaf0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 9999;
            font-family: Arial, sans-serif;
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .custom-alert-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }
    </style>

    <div class='custom-alert'>
        <div class='custom-alert-icon'>✅</div>
        <div><strong>Success!</strong><br>Your profile was updated successfully.</div>
    </div>

    <script>
        setTimeout(() => {
            document.querySelector('.custom-alert').remove();
            window.location.href = 'user_profile.php'; // redirect after showing alert
        }, 2000);
    </script>
    ";
} else {
    echo "<div style='color: red; font-weight: bold;'>Database error: " . htmlspecialchars($conn->error) . "</div>";
}
$conn->close();
?>
