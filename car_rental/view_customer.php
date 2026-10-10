<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: customer_management.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM Customer WHERE Customer_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Customer not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Customer Details</h1>

        <p><strong>Customer ID:</strong> <?php echo $customer['Customer_ID']; ?></p>
        <p><strong>User ID:</strong> <?php echo $customer['User_ID']; ?></p>
        <p><strong>Membership Level:</strong> <?php echo $customer['Membership_Level']; ?></p>
        <p><strong>Reward Points:</strong> <?php echo $customer['Reward_Points']; ?></p>
        <p><strong>Customer Status:</strong> <?php echo $customer['Customer_Status']; ?></p>

        <a href="customer_management.php">
            Back
        </a>

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