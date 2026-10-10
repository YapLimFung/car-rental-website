<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$vehicleCount = 0;
$bookingCount = 0;
$customerCount = 0;
$availableCount = 0;
$rentedCount = 0;

$vehicleResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Vehicle");
if ($vehicleResult) {
    $row = mysqli_fetch_assoc($vehicleResult);
    $vehicleCount = $row['total'];
}

$bookingResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Booking");
if ($bookingResult) {
    $row = mysqli_fetch_assoc($bookingResult);
    $bookingCount = $row['total'];
}

$customerResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Customer");
if ($customerResult) {
    $row = mysqli_fetch_assoc($customerResult);
    $customerCount = $row['total'];
}

$availableResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Vehicle WHERE Current_Status = 'Available'");
if ($availableResult) {
    $row = mysqli_fetch_assoc($availableResult);
    $availableCount = $row['total'];
}

$rentedResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Vehicle WHERE Current_Status = 'Rented'");
if ($rentedResult) {
    $row = mysqli_fetch_assoc($rentedResult);
    $rentedCount = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/vehicle.css">

</head>

<body>

    <div class="dashboard">

        <aside class="sidebar">

            <div class="logo">
                <a href="index.html">
                <img src="images/atas_logo.png" alt="Logo" class="logo">
            </a>
            </div>

            <nav>

                <a href="dashboard.php" class="active">
                    Dashboard
                </a>

                <a href="vehicle_management.php">
                    Vehicle Management
                </a>

                <a href="booking_management.php">
                    Booking Management
                </a>

                <a href="customer_management.php">
                    Customer Management
                </a>

                <a href="logout.php">
                    Logout
                </a>

            </nav>

        </aside>

        <main class="content">

            <div class="top-bar">

                <h1>
                    Dashboard
                </h1>

            </div>

            <div class="dashboard-cards">

                <div class="dash-card">
                    <h3>Total Vehicles</h3>
                    <p><?php echo $vehicleCount; ?></p>
                </div>

                <div class="dash-card">
                    <h3>Total Bookings</h3>
                    <p><?php echo $bookingCount; ?></p>
                </div>

                <div class="dash-card">
                    <h3>Total Customers</h3>
                    <p><?php echo $customerCount; ?></p>
                </div>

                <div class="dash-card">
                    <h3>Available Vehicles</h3>
                    <p><?php echo $availableCount; ?></p>
                </div>

                <div class="dash-card">
                    <h3>Rented Vehicles</h3>
                    <p><?php echo $rentedCount; ?></p>
                </div>

            </div>

            <div class="table-container" style="margin-top: 20px;">

                <h2 style="font-weight: normal; margin-bottom: 15px;">
                    Quick Links
                </h2>

                <a href="vehicle_management.php">
                    <button class="add-btn">
                        Manage Vehicles
                    </button>
                </a>

                <a href="booking_management.php">
                    <button class="add-btn">
                        Manage Bookings
                    </button>
                </a>

                <a href="customer_management.php">
                    <button class="add-btn">
                        Manage Customers
                    </button>
                </a>

                <a href="add_vehicle.php">
                    <button class="add-btn">
                        Add Vehicle
                    </button>
                </a>

                <a href="add_booking.php">
                    <button class="add-btn">
                        Add Booking
                    </button>
                </a>

                <a href="add_customer.php">
                    <button class="add-btn">
                        Add Customer
                    </button>
                </a>

            </div>

        </main>

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