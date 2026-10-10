<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: booking_management.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM Booking WHERE Booking_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Booking not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Booking Details</h1>

        <p><strong>Booking ID:</strong> <?php echo $booking['Booking_ID']; ?></p>
        <p><strong>Customer ID:</strong> <?php echo $booking['Customer_ID']; ?></p>
        <p><strong>Vehicle ID:</strong> <?php echo $booking['Vehicle_ID']; ?></p>
        <p><strong>Status:</strong> <?php echo $booking['Booking_Status']; ?></p>
        <p><strong>Booking Date:</strong> <?php echo $booking['Booking_DateTime']; ?></p>
        <p><strong>Rental Start Date:</strong> <?php echo $booking['Rental_Start_Date']; ?></p>
        <p><strong>Rental End Date:</strong> <?php echo $booking['Rental_End_Date']; ?></p>
        <p><strong>Pickup Location:</strong> <?php echo $booking['Pickup_Location']; ?></p>
        <p><strong>Return Location:</strong> <?php echo $booking['Return_Location']; ?></p>
        <p><strong>Total Rental Amount:</strong> RM<?php echo number_format($booking['Total_Rental_Amount'], 2); ?></p>
        <p><strong>Notes:</strong> <?php echo $booking['Notes']; ?></p>
        <p><strong>Staff Attended ID:</strong> <?php echo $booking['Staff_Attended_ID']; ?></p>
        <p><strong>Staff Service ID:</strong> <?php echo $booking['Staff_Service_ID']; ?></p>

        <a href="booking_management.php">
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