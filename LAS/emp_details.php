<?php
session_start();

// Check if the user is logged in as a manager
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in as a manager
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

// Query to retrieve all employee details
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #6a0dad;
            color: white;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="manager_page.php">Home</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>
<h2>Employee Details</h2>

<!-- Display the employee details in a table -->
<table>
    <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Department</th>
        <th>Earned Leave</th>
        <th>Sick Leave</th>
        <th>Casual Leave</th>
        <th>Date of Joining</th>
        <th>Date of Birth</th>
        <th>Employee Fee</th>
        <th>Employee Type</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Fetch and display each row from the result set
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['UserName']}</td>";
            echo "<td>{$row['EmpName']}</td>";
            echo "<td>{$row['EmpEmail']}</td>";
            echo "<td>{$row['Dept']}</td>";
            echo "<td>{$row['EarnLeave']}</td>";
            echo "<td>{$row['SickLeave']}</td>";
            echo "<td>{$row['CasualLeave']}</td>";
            echo "<td>{$row['DateOfJoin']}</td>";
            echo "<td>{$row['DateOfBirth']}</td>";
            echo "<td>{$row['EmpFee']}</td>";
            echo "<td>{$row['EmpType']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No employee records found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
