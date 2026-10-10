<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); //customer must be logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$selected_vehicle = null;

$cust_query = "SELECT * FROM `Customer` WHERE `User_ID` = $user_id";
$cust_result = $conn->query($cust_query);
$customer = $cust_result->fetch_assoc();
$customer_id = $customer['User_ID'];

if(isset($_GET['vehicle_id'])) {
    $vehicle_id = $_GET['vehicle_id'];
    
    $sel_sql = "SELECT * FROM `Vehicle` WHERE `Vehicle_ID` = $vehicle_id AND `Current_Status` = 'Available'";
    $sel_result = $conn->query($sel_sql);
    
    if($sel_result->num_rows == 1) {
        $selected_vehicle = $sel_result->fetch_assoc();
    } else {
        $error = "Vehicle not available.";
    }
} else {
    $error = "No vehicle selected.";
}

if(isset($_POST['book'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $rental_start = $_POST['rental_start'];
    $rental_end = $_POST['rental_end'];
    $notes = $_POST['notes'];
    
    $start = new DateTime($rental_start);
    $end = new DateTime($rental_end);
    $days = $start->diff($end)->days + 1; //must be atleast 1 day
    
    $rate_sql = "SELECT * FROM `Vehicle` WHERE `Vehicle_ID` = $vehicle_id";
    $rate_result = $conn->query($rate_sql);
    $vehicle = $rate_result->fetch_assoc();
    
    $total_amount = $days * $vehicle['Rate_Type'];
    
    $booking_sql = "INSERT INTO `Booking` (
        `Customer_ID`, `Vehicle_ID`, `Rental_Start_Date`, `Rental_End_Date`,
        `Pickup_Location`, `Return_Location`, `Total_Rental_Amount`,
        `Notes`, `Booking_Status`
    ) VALUES (
        $customer_id, $vehicle_id, '$rental_start', '$rental_end',
        '$pickup_location', '$return_location', $total_amount,
        '$notes', 'Pending'
    )";
    
    if($conn->query($booking_sql)) {
        $booking_id = $conn->insert_id;
        
        $update_vehicle = "UPDATE `Vehicle` SET `Current_Status` = 'Rented' WHERE `Vehicle_ID` = $vehicle_id";
        $conn->query($update_vehicle);
        
        $_SESSION['booking_id'] = $booking_id;
        $_SESSION['total_amount'] = $total_amount;
        
        header("Location: payment.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/booking.css">
<head>
    <title>Book a Car</title>
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


    

    <?php if($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
        <a href="vehicle_listing.php">← Back to Fleet</a>
    <?php endif; ?>

    <?php if($selected_vehicle && !$error): ?>
        
        <div class="vehicle-details">
        <h2>Book a Car</h2><br><br>

        <h3>Vehicle Details</h3>
        <p><strong>Brand:</strong> <?php echo $selected_vehicle['Brand']; ?></p>
        <p><strong>Model:</strong> <?php echo $selected_vehicle['Model']; ?></p>
        <p><strong>Plate:</strong> <?php echo $selected_vehicle['Plate_Number']; ?></p>
        <p><strong>Category:</strong> <?php echo $selected_vehicle['Category']; ?></p>
        <p><strong>Seats:</strong> <?php echo $selected_vehicle['Seating_Capacity']; ?></p>
        <p><strong>Rate:</strong> RM <?php echo number_format($selected_vehicle['Rate_Type'], 2); ?> / day</p>

        </div>


        <div class="booking-form">
        <h3>Booking Details</h3>
        
        <form method="POST">
            <input type="hidden" name="vehicle_id" value="<?php echo $selected_vehicle['Vehicle_ID']; ?>">
            
            <label>Rental Start Date:</label>
            <input type="date" name="rental_start" required>
            <br><br>
            
            <label>Rental End Date:</label>
            <input type="date" name="rental_end" required>
            <br><br>
            
            <label>Pickup Location:</label>
            <select name="pickup_location" required>
                <option value="">Select Location</option>
                <option value="Kuala Lumpur">Kuala Lumpur</option>
                <option value="Selangor">Selangor</option>
                <option value="Penang">Penang</option>
                <option value="Johor Bahru">Johor Bahru</option>
                <option value="Ipoh">Ipoh</option>
                <option value="Seremban">Seremban</option>
            </select>
            <br><br>
            
            <label>Return Location:</label>
            <select name="return_location">
                <option value="">Select Location</option>
                <option value="Kuala Lumpur">Kuala Lumpur</option>
                <option value="Selangor">Selangor</option>
                <option value="Penang">Penang</option>
                <option value="Johor Bahru">Johor Bahru</option>
                <option value="Ipoh">Ipoh</option>
                <option value="Seremban">Seremban</option>
            </select>
            <br><br>
            
            <label>Notes:</label>
            <textarea name="notes" rows="3"></textarea>
            <br><br>
            
            <input type="submit" name="book" value="Proceed to Payment">
        </form>

        <br>
        <a href="vehicle_listing.php" class="choose-another">Choose Another Vehicle</a>

        </div>
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