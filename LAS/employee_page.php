<?php
// Start session to retrieve user information
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect user back to login page if not logged in
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

// Retrieve employee details from the database
$sql = "SELECT * FROM employees WHERE username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {
    // Fetch the data and assign it to variables
    $row = $result->fetch_assoc();
    $empId = $row['id'];
    $empName = $row['EmpName'];
    $empEmail = $row['EmpEmail'];
    $empDept=$row['Dept'];
    $dateofbirth=$row['DateOfBirth'];
    $dateofjoining=$row['DateOfJoin'];
    $sickLeaves = $row['SickLeave'];
    $earnLeaves = $row['EarnLeave'];
    $casualLeaves = $row['CasualLeave'];
    $_SESSION['emp_id'] = $row['id'];
    $_SESSION['emp_name'] = $row['EmpName'];
} else {
    // Handle if no employee details found
    $empId = "";
    $empName = "";
    $empEmail = "";
    $sickLeaves = "";
    $earnLeaves = "";
    $casualLeaves = "";
    $_SESSION['emp_id'] = "";
    $_SESSION['emp_name'] = "";
}
// Fetch leave data from emp_leaves table
$sql = "SELECT LeaveType, COUNT(*) as leave_count FROM emp_leaves WHERE EmpID = '$empId' AND Status = 'Accepted' GROUP BY LeaveType";
$result = $conn->query($sql);

// Initialize leave totals
$sick_leaves = 0;
$earn_leaves= 0;
$casual_leaves = 0;

// Calculate leave totals
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        switch ($row['LeaveType']) {
            case 'sick':
                $sick_leaves = $row['leave_count'];
                break;
            case 'earn':
                $earn_leaves = $row['leave_count'];
                break;
            case 'casual':
                $casual_leaves = $row['leave_count'];
                break;
        }
    }
}

// Update employee leave balances in employees table
$update_sql = "UPDATE employees SET SickLeave = SickLeave - ?, EarnLeave = EarnLeave - ?, CasualLeave = CasualLeave - ? WHERE id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("iiii", $sick_leaves_taken, $earn_leaves_taken, $casual_leaves_taken, $emp_id);

// Close database connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
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
            padding: 20px;
        }
        .employee-details {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .employee-details h2 {
            text-align: center;
            color: #6a0dad;
            margin-bottom: 20px;
        }
        .detail {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .detail label {
            font-weight: bold;
            font-size: 18px;
            color: #6a0dad;
            flex-basis: 30%;
        }
        .detail span {
            font-size: 16px;
            flex-basis: 60%;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="employee_page.php">Home</a>
    <a href="RequestLeave.php">Request a Leave</a>
    <a href="myrequests.php">My Requests</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>

<div class="content">
    <div class="employee-details">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <div class="detail">
            <label>Employee ID:</label>
            <span><?php echo $empId; ?></span>
        </div>
        <div class="detail">
            <label>Name:</label>
            <span><?php echo $empName; ?></span>
        </div>
        <div class="detail">
            <label>Email:</label>
            <span><?php echo $empEmail; ?></span>
        </div>
        <div class="detail">
            <label>Date of Birth:</label>
            <span><?php echo $dateofbirth; ?></span>
        </div>
       
        <div class="detail">
            <label>Department:</label>
            <span><?php echo $empDept; ?></span>
        </div>
        <div class="detail">
            <label>Sick Leaves:</label>
            <span><?php echo $sick_leaves; ?></span>
        </div>
        <div class="detail">
            <label>Earn Leaves:</label>
            <span><?php echo $earn_leaves; ?></span>
        </div>
        <div class="detail">
            <label>Casual Leaves:</label>
            <span><?php echo $casual_leaves; ?></span>
        </div>
        <div class="detail">
            <label>Date of Joining:</label>
            <span><?php echo $dateofjoining; ?></span>
        </div>
        <!-- Add more details as needed -->
    </div>
</div>

</body>
</html>
