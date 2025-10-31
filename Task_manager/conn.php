<?php

// CONFIGURE: Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Set your MySQL password
$dbname = "task_manager"; // Change to your database name

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>