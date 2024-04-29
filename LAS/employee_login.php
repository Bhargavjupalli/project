<?php
// Start session to store user information
session_start();

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

// Retrieve form data
$UserName = $_POST['username'];
$EmpPass = $_POST['password'];

// Prepare SQL statement to select user from database
$stmt = $conn->prepare("SELECT * FROM employees WHERE UserName = ? AND EmpPass = ?");
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters to the prepared statement
$stmt->bind_param("ss", $UserName, $EmpPass);

// Execute SQL statement
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

// Get result set
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // User exists, set session variables and redirect to employee page
    $_SESSION['username'] = $UserName;
    header("Location: employee_page.php");
    exit();
} else {
    // User does not exist, redirect back to login page with error message
    $_SESSION['error'] = "Invalid username or password";
    header("Location: login.php");
    exit();
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
