<?php

$db = mysqli_connect("localhost", "root", "", "js_bank");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if(isset($_SESSION["username"])){
    header("Location: dashboard.php");
    exit();
}

$error = null;
$success = false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = mysqli_real_escape_string($db, $_POST["name"]);
    $email = mysqli_real_escape_string($db, $_POST["email"]);
    $phone = mysqli_real_escape_string($db, $_POST["phone"]);
    $address = mysqli_real_escape_string($db, $_POST["address"]);
    $city = mysqli_real_escape_string($db, $_POST["city"]);
    $state = mysqli_real_escape_string($db, $_POST["state"]);
    $pincode = mysqli_real_escape_string($db, $_POST["pincode"]);
    $username = mysqli_real_escape_string($db, $_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];
    
    $check_username = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_username) > 0){
        $error = "Username already exists";
    }
    else if($password != $confirm_password){
        $error = "Password and Confirm Password do not match";
    }
    else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone, address, city, state, pincode, username, password) 
                VALUES ('$name', '$email', '$phone', '$address', '$city', '$state', '$pincode', '$username', '$hashed_password')";
        
        if(mysqli_query($db, $sql)){
            $success = true;
        } else {
            $error = "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
}

if($error !== null){
    echo "<script>alert('$error');</script>";
} else if($success){
    echo "<script>alert('Account created successfully');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Account</title>
    <link rel="stylesheet" href="../style/header-style.css">
    <link rel="stylesheet" href="../style/open-account-style.css">
    <link rel="stylesheet" href="../style/footer-style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
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
    <main>
        <div class="open-account-container">
            <div class="open-account-form">
                <h1>Open Account</h1>
                <form action="open-account.php" method="post">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Full Name" required>
                    
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" placeholder="Phone" required>
                    
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="Address" required>
                    
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" placeholder="City" required>
                    
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" placeholder="State" required>
                    
                    <label for="pincode">Pincode</label>
                    <input type="text" name="pincode" id="pincode" placeholder="Pincode" required>
                    
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
                    
                    <button type="submit" name="open-account">Open Account</button> 
                </form>
            </div>
            <div class="signup-link">
                <p>Already have an account? <a href="login.php">Login</a> or <a href="../index.html">Home page</a></p>
            </div>  
        </div>
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 JS Bank. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>