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

//in profree host --- 
//$servername = "sql109.ezyro.com";    From your ProFreeHost MySQL section
//$username = "ezyro_40229821";
//$password = "T@skM@nager2025!";
//$dbname = "ezyro_40229821_task_manager";

//$conn = mysqli_connect($servername, $username, $password, $dbname);

//if (!$conn) {
//    die("<h3 style='color:red;'>❌ Connection failed: " . mysqli_connect_error() . "</h3>");
//}
//echo "<h3 style='color:green;'>✅ Connected successfully to the database!</h3>";
?>

