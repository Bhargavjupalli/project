<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Prepare a statement to fetch the hashed password from the database
    $stmt = $conn->prepare("SELECT EmpPass FROM employees WHERE UserName = ?");
    $stmt->bind_param("s", $entered_username);
    $stmt->execute();
    $stmt->bind_result($stored_hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Debugging output (for troubleshooting only)
    // echo "Entered password: " . $entered_password . "<br>";
    // echo "Stored hashed password: " . $stored_hashed_password . "<br>";

    // Verify the entered password against the stored hashed password
    if (password_verify($entered_password, $stored_hashed_password)) {
        // Password matches, set the session variables and redirect
        $_SESSION['username'] = $entered_username;
        header("Location: employee_page.php");
        exit();
    } else {
        // Incorrect password
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: index.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
        }

        .main {
            width: 350px;
            height: 500px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 5px 20px 50px;
        }

        #chk {
            display: none;
        }

        .signup,
        .login {
            position: relative;
            width: 100%;
            height: 100%;
        }

        label {
            color: #573b8a;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        input {
            width: 60%;
            height: 20px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        button {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }

        button:hover {
            background: #6d44b8;
        }

        .login {
            height: 460px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
        }

        .login label {
            color: #573b8a;
            transform: scale(.6);
        }

        #chk:checked~.login {
            transform: translateY(-500px);
        }

        #chk:checked~.login label {
            transform: scale(1);
        }

        #chk:checked~.signup label {
            transform: scale(.6);
        }

        .forgot-password {
            color: #573b8a;
            text-align: center;
            display: block;
            margin: 10px;
            font-size: 0.9em;
            cursor: pointer;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="main">
        <center><h1>Leave Application System</h1></center>

        <?php
        // Check for error messages and display them
        if (isset($_SESSION['error'])) {
            echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <input type="checkbox" id="chk" aria-hidden="true">

        <!-- Employee Login -->
        <div class="signup">
            <form method="POST" action="employee_login.php">
                <label for="chk" aria-hidden="true">Employee</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Manager Login -->
        <div class="login">
            <form method="POST" action="manager_login.php">
                <label for="chk" aria-hidden="true">Manager</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
