<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>loginform</title>
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<style type="text/css">
    body{
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: 'Jost', sans-serif;
}
.main{
    width: 350px;
    height: 500px;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 5px 20px 50px;
}
#chk{
    display: none;
}
.signup{
    position: relative;
    width:100%;
    height: 100%;
}
label{
    color: #573b8a;
    font-size: 2.3em;
    justify-content: center;
    display: flex;
    margin: 60px;
    font-weight: bold;
    cursor: pointer;
    transition: .5s ease-in-out;
}
input{
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
button{
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
button:hover{
    background: #6d44b8;
}
.login{
    height: 460px;
    background: #eee;
    border-radius: 60% / 10%;
    transform: translateY(-180px);
    transition: .8s ease-in-out;
}
.login label{
    color: #573b8a;
    transform: scale(.6);
}

#chk:checked ~ .login{
    transform: translateY(-500px);
}
#chk:checked ~ .login label{
    transform: scale(1);    
}
#chk:checked ~ .signup label{
    transform: scale(.6);
}

</style>
</head>
<body>
    <div class="main">
    <center><h1>Leave Application System</h1></center>  
    <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red; text-align: center;'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form method='POST' action="employee_login.php">
                    <label for="chk" aria-hidden="true">Employee</label>
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button>Login</button>
                </form>
            </div>

            <div class="login">
                <form method='POST' action='manager_login.php'>
                    <label for="chk" aria-hidden="true">Manager</label>
                    <input type="text" name="username" placeholder="Username" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button>Login</button>
                </form>
            </div>
    </div>
</body>
</html>