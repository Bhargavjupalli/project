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

// Handle accept and reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // Accept or reject action
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    if ($action == 'accept') {
        // Update status to Accepted
        $sql = "UPDATE emp_leaves SET Status = 'Accepted' WHERE RequestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $request_id);
    } elseif ($action == 'reject') {
        // Update status to Rejected and store the reason for rejection
        $sql = "UPDATE emp_leaves SET Status = 'Rejected', RejectionReason = ? WHERE RequestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $reason, $request_id);
    }

    // Execute the query
    if ($stmt->execute() !== TRUE) {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


// Query the database for employee leave requests in Processing status
$sql = "SELECT * FROM emp_leaves WHERE Status = 'Processing'";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Requests</title>
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
        /* CSS for buttons */
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .accept-btn {
            background-color: #4caf50;
            color: white;
        }
        .reject-btn {
            background-color: #f44336;
            color: white;
        }
        /* CSS for hidden input field */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="manager_page.php">Home</a>
    <a href="logout.php" style="float: right;">Logout</a>
</div>

<div class="content">
    <h2>Review Requests</h2>
    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Leave Type</th>
                <th>Request Date</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['EmpName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['LeaveType']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['RequestDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['StartDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['EndDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Reason']) . "</td>";
                    echo "<td>
                            <form method='POST' class='action-form'>
                                <input type='hidden' name='request_id' value='" . htmlspecialchars($row['RequestId']) . "'>
                                <input type='hidden' name='action' class='action-input' value=''>
                                <input type='hidden' name='reason' class='reason-input' value=''>
                                <button type='button' class='accept-btn' onclick='handleAction(this, \"accept\")'>Accept</button>
                                <button type='button' class='reject-btn' onclick='handleAction(this, \"reject\")'>Reject</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function handleAction(button, action) {
    // Get the form element
    const form = button.closest('.action-form');
    
    // Get the action and reason input fields
    const actionInput = form.querySelector('.action-input');
    const reasonInput = form.querySelector('.reason-input');
    
    // Set the action value
    actionInput.value = action;
    
    // Check if action is reject
    if (action === 'reject') {
        // Prompt the user for the reason for rejection
        const reason = prompt(' Reason for rejection:');
        
        // If a reason was entered, set the reason input value and submit the form
        if (reason) {
            reasonInput.value = reason;
            form.submit();
        }
    } else {
        // Submit the form
        form.submit();
    }
}
</script>

</body>
</html>
`
