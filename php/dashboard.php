<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
}

// Database connection
$db = mysqli_connect("localhost", "root", "", "js_bank");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user data securely
$username = mysqli_real_escape_string($db, $_SESSION["username"]);
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($db, $query);

if(!$result || mysqli_num_rows($result) == 0){
    // If user not found in database, destroy session and redirect
    session_destroy();
    header("Location: login.php");
    exit();
}

$user = mysqli_fetch_assoc($result);
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - JS Bank</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/header-style.css">
    <link rel="stylesheet" href="../style/dashboard-style.css">
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
            <div class="login-button">
                <form action="logout.php" method="POST">
                    <input type="submit" value="Logout">
                </form>
            </div>  

        </div>
    </header>
    <main>
        <div class="welcome-section">
            <h1>Welcome <?php echo htmlspecialchars($user["name"]); ?></h1>
            <div class="user-info">
                <p>Email: <?php echo htmlspecialchars($user["email"]); ?></p>
                <p>Phone: <?php echo htmlspecialchars($user["phone"]); ?></p>
                <p>Address: <?php echo htmlspecialchars($user["address"]); ?></p>
                <p>City: <?php echo htmlspecialchars($user["city"]); ?></p>
                <p>State: <?php echo htmlspecialchars($user["state"]); ?></p>
                <p>Pincode: <?php echo htmlspecialchars($user["pincode"]); ?></p>
            </div>
        </div>

        <div class="banking-offers">
            <h2>Exclusive Banking Offers</h2>
            <div class="offers-grid">
                <div class="offer-card fd">
                    <h3>Fixed Deposits</h3>
                    <div class="offer-details">
                        <p class="rate">Up to 7.50% p.a.</p>
                        <ul>
                            <li>Special rates for senior citizens</li>
                            <li>Flexible tenure: 7 days to 10 years</li>
                            <li>Minimum deposit: ₹10,000</li>
                            <li>Quarterly interest payout</li>
                        </ul>
                        <button class="apply-btn" onclick="window.location.href='fixed-deposit.php'">Apply Now</button>
                    </div>
                </div>

                <div class="offer-card rd">
                    <h3>Recurring Deposits</h3>
                    <div class="offer-details">
                        <p class="rate">Up to 7.00% p.a.</p>
                        <ul>
                            <li>Monthly investment from ₹1,000</li>
                            <li>Tenure: 6 months to 10 years</li>
                            <li>Auto-debit facility</li>
                            <li>Loan facility available</li>
                        </ul>
                        <button class="apply-btn" onclick="window.location.href='recurring-deposit.php'">Apply Now</button>
                    </div>
                </div>

                <div class="offer-card investment">
                    <h3>Investment Plans</h3>
                    <div class="offer-details">
                        <p class="rate">Returns up to 12%*</p>
                        <ul>
                            <li>Mutual Funds</li>
                            <li>Stock Trading</li>
                            <li>Tax-Saving ELSS</li>
                            <li>Gold Investment</li>
                        </ul>
                        <button class="apply-btn" onclick="window.location.href='investments.php'">Invest Now</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="special-features">
            <h2>Premium Banking Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="ri-shield-check-fill"></i>
                    <h3>Zero Balance Account</h3>
                    <p>Maintain zero balance with premium features</p>
                </div>
                <div class="feature-card">
                    <i class="ri-bank-card-fill"></i>
                    <h3>Premium Credit Card</h3>
                    <p>Exclusive rewards and cashback</p>
                </div>
                <div class="feature-card">
                    <i class="ri-home-4-fill"></i>
                    <h3>Home Loan</h3>
                    <p>Interest rates starting from 8.50%</p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 JS Bank. All rights reserved.</p>
    </footer>   
    
</body>
</html>