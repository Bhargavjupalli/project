<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user back to the login page if not logged in
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

// Retrieve employee ID from session
$emp_id = $_SESSION['emp_id'];

// Query the database for the employee's leave requests
$sql = "SELECT * FROM emp_leaves WHERE EmpID = '$emp_id'";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #6a0dad;
            color: white;
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
    <h2>My Requests</h2>
    <table>
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Request Date</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Rejection Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['LeaveType']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['RequestDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['StartDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['EndDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Reason']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                    // Display rejection reason if the request is rejected
                    if ($row['Status'] == 'Rejected') {
                        echo "<td>" . htmlspecialchars($row['RejectionReason']) . "</td>";
                    } else {
                        echo "<td>-</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No leave requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
