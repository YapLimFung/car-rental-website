<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login_page.html");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];


$cust_query = "SELECT * FROM `Customer` WHERE `User_ID` = $user_id";
$cust_result = $conn->query($cust_query);
$customer = $cust_result->fetch_assoc();
$customer_id = $customer['User_ID'];

$bookings_sql = "SELECT b.*, v.Brand, v.Model, v.Plate_Number, 
                 p.Payment_Status, p.Amount as Payment_Amount
                 FROM `Booking` b 
                 JOIN `Vehicle` v ON b.Vehicle_ID = v.Vehicle_ID 
                 LEFT JOIN `Payment` p ON b.Booking_ID = p.Booking_ID
                 WHERE b.Customer_ID = $customer_id 
                 ORDER BY b.Booking_DateTime DESC";
$bookings_result = $conn->query($bookings_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - ATAS Car Rental</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .user-info { color: #666; }
        .user-info strong { color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f9f9f9; color: #333; font-weight: 600; }
        tr:hover { background: #f9f9f9; }
        .status { padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .back-link { color: #c9a84c; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
        .btn {
            padding: 8px 15px;
            background: #c9a84c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #b8963a;
        }
        @media (max-width: 768px) {
            .container { padding: 15px; overflow-x: auto; }
            table { font-size: 14px; }
            th, td { padding: 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>My Bookings</h2>
            <div class="user-info">
                Welcome, <strong><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></strong>
                <a href="logout.php" style="margin-left: 15px; color: #c9a84c;">Logout</a>
            </div>
        </div>

        <?php if($bookings_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Vehicle</th>
                        <th>Plate</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = $bookings_result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['Booking_ID']; ?></td>
                            <td><?php echo $booking['Brand'] . ' ' . $booking['Model']; ?></td>
                            <td><?php echo $booking['Plate_Number']; ?></td>
                            <td><?php echo date('d M Y', strtotime($booking['Rental_Start_Date'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($booking['Rental_End_Date'])); ?></td>
                            <td>RM <?php echo number_format($booking['Total_Rental_Amount'], 2); ?></td>
                            <td>
                                <span class="status status-<?php echo strtolower($booking['Booking_Status']); ?>">
                                    <?php echo $booking['Booking_Status']; ?>
                                </span>
                            </td>
                            <td><?php echo $booking['Payment_Status'] ?? 'Pending'; ?></td>
                            <td>
                                <?php if($booking['Booking_Status'] == 'Confirmed'): ?>
                                    <a href="booking_details.php?id=<?php echo $booking['Booking_ID']; ?>" class="btn">View</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; padding: 40px; color: #666;">You haven't made any bookings yet.</p>
            <p style="text-align: center;"><a href="booking.php" style="color: #c9a84c;">Book your first car now →</a></p>
        <?php endif; ?>
        
        <br>
        <a href="booking.php" class="back-link">← Book a Car</a>
        <br>
        <a href="index.html" class="back-link">← Back to Home</a>
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