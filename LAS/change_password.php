<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if not logged in
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
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify that the new passwords match
    if ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match.";
    } else {
        // Retrieve the current user's username from the session
        $username = $_SESSION['username'];

        // Fetch the current password from the database
        $stmt = $conn->prepare("SELECT EmpPass FROM employees WHERE UserName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($db_current_password);
        $stmt->fetch();
        $stmt->close();

        // Verify the current password
        if ($current_password === $db_current_password) {
    // Hash the new password for storage

    // Update the password in the database with the hashed new password
    $update_stmt = $conn->prepare("UPDATE employees SET EmpPass = ? WHERE UserName = ?");
    $update_stmt->bind_param("ss", $new_password, $username);
    if ($update_stmt->execute()) {
        $success_message = "Password changed successfully.";
    } else {
        $error_message = "Failed to update the password.";
    }
    // Close the prepared statement
    $update_stmt->close();
        } else {
            $error_message = "Current password is incorrect.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
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
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #49236d;
        }

        .message {
            text-align: center;
            margin-top: 10px;
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
    <a href="employee_page.php">Home</a>
    <a href="RequestLeave.php">Request a Leave</a>
    <a href="myrequests.php">My Requests</a>
    <a href="change_password.php">change password</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>

    <div class="content">
        <h2>Change Password</h2>
        <form method="POST" action="change_password.php">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Change Password">
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
