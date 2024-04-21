<?php
session_start();

// Check if the user is logged in and is a manager
if (!isset($_SESSION['username'])){
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

// Initialize feedback messages
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $emp_pass = password_hash($_POST['emp_pass'], PASSWORD_DEFAULT); // Hash the password
    $emp_name = trim($_POST['emp_name']);
    $emp_email = trim($_POST['emp_email']);
    $dept = trim($_POST['dept']);
    $earn_leave = (int)$_POST['earn_leave'];
    $sick_leave = (int)$_POST['sick_leave'];
    $casual_leave = (int)$_POST['casual_leave'];
    $date_of_join = trim($_POST['date_of_joining']);
    $date_of_birth = trim($_POST['date_of_birth']);
    $emp_fee = trim($_POST['emp_fee']);
    $emp_type = trim($_POST['emp_type']);


    // Prepare and execute the SQL query to insert the new employee
    $stmt = $conn->prepare("INSERT INTO employees (UserName, EmpPass, EmpName, EmpEmail, Dept, EarnLeave, SickLeave, CasualLeave, DateOfJoin, DateOfBirth, EmpFee, EmpType)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssiiissss",$username, $emp_pass, $emp_name, $emp_email, $dept, $earn_leave, $sick_leave, $casual_leave, $date_of_join, $date_of_birth, $emp_fee, $emp_type);

    // Check if the query executed successfully
    if ($stmt->execute()) {
        $success_message = "New employee registered successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register New Employee</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .navbar {
            background-color: #6a0dad;
            color: white;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #49236d;
        }
        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #6a0dad;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input:focus,
        select:focus {
            border-color: #6a0dad;
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #6a0dad;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #49236d;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="manager_page.php">Home</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>

<div class="content">
    <h2>Register New Employee</h2>
    <form action="RegisterEmployee.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="emp_pass">Password:</label>
        <input type="password" id="emp_pass" name="emp_pass" required>

        <label for="emp_name">Employee Name:</label>
        <input type="text" id="emp_name" name="emp_name" required>

        <label for="emp_email">Email:</label>
        <input type="email" id="emp_email" name="emp_email" required>

        <label for="dept">Department:</label>
        <input type="text" id="dept" name="dept" required>

        <label for="earn_leave">Earned Leave:</label>
        <input type="number" id="earn_leave" name="earn_leave" required>

        <label for="sick_leave">Sick Leave:</label>
        <input type="number" id="sick_leave" name="sick_leave" required>

        <label for="casual_leave">Casual Leave:</label>
        <input type="number" id="casual_leave" name="casual_leave" required>

        <label for="date_of_joining">Date of Joining:</label>
        <input type="date" id="date_of_joining" name="date_of_joining" required>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>

        <label for="emp_fee">Employee Fee:</label>
        <input type="text" id="emp_fee" name="emp_fee" required>

        <label for="emp_type">Employee Type:</label>
        <input type="text" id="emp_type" name="emp_type" required>

        <input type="submit" value="Register Employee">
    </form>

    <!-- Display success or error message -->
    <div class="message">
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php elseif ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
