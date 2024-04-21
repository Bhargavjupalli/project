<?php
session_start();

// Check if user is logged in as a manager
if (!isset($_SESSION['username']))
{
    // Redirect the user back to the login page if not logged in as a manager
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "phpdb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle any manager-specific actions, e.g., reviewing leave requests, etc.

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Page</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #6a0dad;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #49236d;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        h2 {
            color: #6a0dad;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Manager Tools</h2>
    <a href="ReviewRequests.php">Review Requests</a>
    <a href="RegisterEmployee.php">Register New Employee</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <!-- Add manager-specific content here, e.g., review leave requests, manage employees, etc. -->
</div>

</body>
</html>
