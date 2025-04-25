<?php
session_start();

if(isset($_SESSION["username"])){
    header("Location: dashboard.php");
    exit();
}

$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $db = mysqli_connect("localhost", "root", "", "js_bank");
    
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = mysqli_real_escape_string($db, $_POST["username"]);
    $password = $_POST["password"];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);
    
    if($result && mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    
    mysqli_close($db);
}

if(isset($error)){
    echo "<script>alert('$error');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to JS-Bank</title>
    <link rel="stylesheet" href="../style/header-style.css">
    <link rel="stylesheet" href="../style/login-style.css">
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="logo">
                <a href="../index.html"><img src="../images/bnak-logo.JPG" alt="logo"></a>
            </div>
            <div class="contact-info">
                <span><i class="ri-phone-fill"></i> JS Bank</span>
                <span><i class="ri-mail-line"></i> contact@jsbank.com</span>
                <span><i class="ri-time-line"></i> Mon-Fri: 9:00 AM - 5:00 PM</span>
            </div>
        </div>
    </header>
    <div class="login-container">
        <div class="login-form">
            <h2>Login to JS-Bank</h2>
            <form action="login.php" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required><br><br>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required><br><br> 
                
                <button type="submit">Login</button><br><br>
                <a href="#">Forgot Password?</a>
            </form>
        </div>
        <div class="signup-link">
            <p>Don't have an account? <a href="open-account.php">Sign up</a> or <a href="../index.html">Home page</a></p>
        </div>
    </div>
    
</body>
</html>