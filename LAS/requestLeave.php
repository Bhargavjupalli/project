<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect user back to the login page if not logged in
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

// Initialize variables
$success_message = '';
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $leave_type = $_POST['leave_type'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $reason = $_POST['reason'] ?? '';

    // Retrieve employee details from session
    if (isset($_SESSION['emp_id']) && isset($_SESSION['emp_name'])) {
        $emp_id = $_SESSION['emp_id'];
        $emp_name = $_SESSION['emp_name'];
    } else {
        // Handle the case where session variables are not set
        $error_message = "Error: Employee details not found in session.";
    }

    // Get current date
    $request_date = date("Y-m-d");

    // Insert leave request into database with initial status as "Processing"
    if (!empty($emp_id) && !empty($emp_name)) {
        $sql = "INSERT INTO emp_leaves (EmpID, EmpName, LeaveType, RequestDate, StartDate, EndDate, Reason, Status)
                VALUES ('$emp_id', '$emp_name', '$leave_type', '$request_date', '$start_date', '$end_date', '$reason', 'Processing')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Leave Requested Successfully";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Request a Leave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Flatpickr CSS -->
    <style>
        /* Styles for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
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
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #6a0dad;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
        }
        input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #49236d;
        }
        .calendar-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #6a0dad;
            cursor: pointer;
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
    <a href="employee_page.php">Home</a>
    <a href="RequestLeave.php">Request a Leave</a>
    <a href="myrequests.php">My Requests</a>
    <a href="change_password.php">change password</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>

<div class="content">
    <h2>Request a Leave</h2>
    <form action="requestLeave.php" method="POST">
        <label for="leave_type">Leave Type:</label>
        <select name="leave_type" id="leave_type" required>
            <option value="">Select Leave Type</option>
            <option value="sick">Sick Leave</option>
            <option value="casual">Casual Leave</option>
            <option value="earn">Earn Leave</option>
        </select>

        <label for="start_date">Start Date:</label>
        <div style="position: relative;">
            <input type="text" name="start_date" id="start_date" placeholder="Select start date" required>
            <i class="far fa-calendar-alt calendar-icon" onclick="toggleCalendar('start_date')"></i>
        </div>

        <label for="end_date">End Date:</label>
        <div style="position: relative;">
            <input type="text" name="end_date" id="end_date" placeholder="Select end date" required>
            <i class="far fa-calendar-alt calendar-icon" onclick="toggleCalendar('end_date')"></i>
        </div>

        <label for="reason">Reason:</label>
        <textarea name="reason" id="reason" rows="4" placeholder="Enter reason for leave" required></textarea>

        <input type="submit" value="Submit">
    </form>
    
    <!-- Display success or error message -->
    <?php if (isset($success_message)) { ?>
        <div class="message success-message"><?php echo htmlspecialchars($success_message); ?></div>
    <?php } ?>

    <?php if (isset($error_message)) { ?>
        <div class="message error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php } ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script>
    function toggleCalendar(id) {
        flatpickr("#" + id, {
            dateFormat: "Y-m-d",
        });
    }
</script>

</body>
</html>
