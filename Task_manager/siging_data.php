<?php
session_start();
include 'conn.php';

// Signup logic =======
if (isset($_POST['signup_btn'])) {
    $full_name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email         = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password      = mysqli_real_escape_string($conn, $_POST['password']);
    $co_password   = mysqli_real_escape_string($conn, $_POST['co_password']);

    // Check if passwords match
    if ($password !== $co_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: login.php");
        exit();
    }

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("Location: login.php");
        exit();
    }

    // Split full name
    $name_parts = explode(" ", $full_name);
    $firstName = $name_parts[0];
    $lastName = isset($name_parts[1]) ? implode(" ", array_slice($name_parts, 1)) : '';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into DB
    $query = "INSERT INTO users (first_name, last_name, email, password) 
              VALUES ('$firstName', '$lastName', '$email', '$hashed_password')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Signup successful! Please login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Signup failed. Please try again.";
        header("Location: login.php");
        exit();
    }
}

// Login logic ========
if (isset($_POST['login_btn'])) {
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $check_user = "
        SELECT u.id, u.first_name, u.last_name, u.email, u.password, i.profile_picture FROM users u
        LEFT JOIN info_user i ON u.id = i.user_id WHERE u.email='$email' LIMIT 1 ";
    $result = mysqli_query($conn, $check_user);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            // Clear old errors
            unset($_SESSION['error']);

            $_SESSION['user_id']          = $user['id'];
            $_SESSION['user_first_name']  = $user['first_name'];
            $_SESSION['user_last_name']   = $user['last_name'];
            $_SESSION['user_email']       = $user['email'];
            $_SESSION['profile_picture']  = $user['profile_picture']; // NEW

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email!";
        header("Location: login.php");
        exit();
    }
}

?>
