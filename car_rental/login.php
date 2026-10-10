<?php
session_start();
include "db.php";

$error = "";

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `User` WHERE `Email` = '$email' AND `Password` = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['User_ID'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['first_name'] = $user['First_Name'];
        $_SESSION['last_name'] = $user['Last_Name'];
        $_SESSION['user_type'] = $user['User_Type'];
        
        header("Location: index.html");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/login.css">
<head>
    <title>Login</title>
    <style>
        body{
            text-align: center;
        }
        .error { 
            color: red; 
        }
        input { 
            padding: 8px; margin: 5px; 
        }
    </style>
</head>

<body>

<header> 
        <div class="header-container">
            <a href="index.html">
                <img src="images/atas_logo.png" alt="Logo" class="logo">
            </a>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="submit_form.php">Contact</a></li>
                </ul>
            </nav>
                <a href="login.php" class="login-button">👤</a>
        </div>
        <hr>
    </header>


    <div class="login-container">
    <h2>User Login</h2><br>

    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email: </label>
        <input type="email" name="email" required><br><br>

        <label>Password: </label>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="login" value="Login" class="login">
    </form>
    
    <br>
    <a href="register.php" class="link">Don't have an account? Register here</a>
    </div>


    <footer>
    <hr>
    <div class="footer-section">
        

        <div class="logotext">
            <img src="images/atas_logo.png" alt="Logo" class="logo-footer">

            <div class="footer-logo-text">
                <h3>Stay connected with us!</h3>
                <a href="https://www.facebook.com/">Facebook</a>
                <a href="https://www.instagram.com/">Instagram</a>
            </div>

        </div>

        <div class="footer-section2">

            <div class="footer-content">
                <h3>Account</h3>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="register_staff.php">Staff Registration</a>
                <a href="dashboard.php">Dashboard</a>
            </div>

            <div class="footer-content">
                <h3>About</h3>
                <a href="about.html">Learn More</a>
                <a href="promotions.html">Promotions</a>
                <a href="services.html">Services</a>
            </div>

            <div class="footer-content">
                <h3>Help</h3>
                <a href="faq.html">FAQ</a>
                <a href="contact.html">Contact Us</a>
            </div>
        </div>
        
    </div>
</footer>
</body>
</html>