<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: vehicle_management.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM Vehicle WHERE Vehicle_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();

if (!$vehicle) {
    echo "Vehicle not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicle</title>
    <link rel="stylesheet" href="css/vehicle.css">

</head>

<body>

    <div class="form-container">

        <h1>Vehicle Details</h1>

        <?php if (!empty($vehicle['Image_URL'])) { ?>
            <img
                src="<?php echo $vehicle['Image_URL']; ?>"
                style="width:100%; max-height:220px; object-fit:cover; margin-bottom:15px;"
                alt="Vehicle Image">
        <?php } ?>

        <p><strong>Vehicle ID:</strong> <?php echo $vehicle['Vehicle_ID']; ?></p>
        <p><strong>Plate Number:</strong> <?php echo $vehicle['Plate_Number']; ?></p>
        <p><strong>Brand:</strong> <?php echo $vehicle['Brand']; ?></p>
        <p><strong>Model:</strong> <?php echo $vehicle['Model']; ?></p>
        <p><strong>Category:</strong> <?php echo $vehicle['Category']; ?></p>
        <p><strong>Year:</strong> <?php echo $vehicle['Year']; ?></p>
        <p><strong>Seats:</strong> <?php echo $vehicle['Seating_Capacity']; ?></p>
        <p><strong>Daily Rate:</strong> RM<?php echo number_format($vehicle['Rate_Type'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo $vehicle['Current_Status']; ?></p>
        <p><strong>Description:</strong> <?php echo $vehicle['Description']; ?></p>
        <p><strong>Last Maintenance:</strong> <?php echo $vehicle['Last_Maintenance']; ?></p>

        <a href="vehicle_management.php">
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