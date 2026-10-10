<?php
session_start();
include "db.php";

$sql = "SELECT * FROM `Vehicle` ORDER BY `Brand` ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link href="css/vehicle_listing.css" rel="stylesheet">
    <title>Our Fleet - ATAS Car Rental</title>
   
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

<h2 class="page-title">Our Fleet</h2>

<?php if($result->num_rows > 0): ?>
    <div class="vehicle-list">
        <?php while($vehicle = $result->fetch_assoc()): ?>
            <div class="vehicle-item">
                <h3><?php echo $vehicle['Brand'] . ' ' . $vehicle['Model']; ?></h3>
                <p>Plate: <?php echo $vehicle['Plate_Number']; ?></p>
                <p>Category: <?php echo $vehicle['Category']; ?></p>
                <p>Seats: <?php echo $vehicle['Seating_Capacity']; ?></p>
                <p>Year: <?php echo $vehicle['Year']; ?></p>
                <p class="price">RM <?php echo number_format($vehicle['Rate_Type'], 2); ?> / day</p>
                <p>Status: 
                    <?php if($vehicle['Current_Status'] == 'Available'): ?>
                        <span class="available">Available</span>
                    <?php else: ?>
                        <span class="unavailable">Not Available</span>
                    <?php endif; ?>
                </p>
                
                <?php if($vehicle['Current_Status'] == 'Available'): ?>
                    <a href="booking.php?vehicle_id=<?php echo $vehicle['Vehicle_ID']; ?>" class="book-btn">Book Now</a>
                <?php else: ?>
                    <span class="unavailable-btn">Not Available</span>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p class="no-vehicles">No vehicles available.</p>
<?php endif; ?>

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