<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$message = "";
$messageColor = "green";

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

if (isset($_POST['submit'])) {

    $booking_status = $_POST['booking_status'];
    $rental_start_date = $_POST['rental_start_date'];
    $rental_end_date = $_POST['rental_end_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $total_rental_amount = $_POST['total_rental_amount'];
    $notes = $_POST['notes'];

    $update = $conn->prepare("UPDATE Booking SET
        Booking_Status = ?,
        Rental_Start_Date = ?,
        Rental_End_Date = ?,
        Pickup_Location = ?,
        Return_Location = ?,
        Total_Rental_Amount = ?,
        Notes = ?
        WHERE Booking_ID = ?");

    $update->bind_param(
        "sssssdsi",
        $booking_status,
        $rental_start_date,
        $rental_end_date,
        $pickup_location,
        $return_location,
        $total_rental_amount,
        $notes,
        $id
    );

    if ($update->execute()) {
        $message = "Booking updated successfully!";
        $messageColor = "green";

        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
    } else {
        $message = "Error updating booking: " . $update->error;
        $messageColor = "red";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Edit Booking</h1>

        <?php if ($message != "") { ?>
            <p style="color: <?php echo $messageColor; ?>;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Booking Status</label>
            <select name="booking_status" required>
                <option value="Confirmed" <?php if ($booking['Booking_Status'] == "Confirmed") echo "selected"; ?>>Confirmed</option>
                <option value="Pending" <?php if ($booking['Booking_Status'] == "Pending") echo "selected"; ?>>Pending</option>
                <option value="Cancelled" <?php if ($booking['Booking_Status'] == "Cancelled") echo "selected"; ?>>Cancelled</option>
                <option value="Completed" <?php if ($booking['Booking_Status'] == "Completed") echo "selected"; ?>>Completed</option>
            </select>

            <label>Rental Start Date</label>
            <input type="date" name="rental_start_date" value="<?php echo $booking['Rental_Start_Date']; ?>" required>

            <label>Rental End Date</label>
            <input type="date" name="rental_end_date" value="<?php echo $booking['Rental_End_Date']; ?>" required>

            <label>Pickup Location</label>
            <input type="text" name="pickup_location" value="<?php echo $booking['Pickup_Location']; ?>" required>

            <label>Return Location</label>
            <input type="text" name="return_location" value="<?php echo $booking['Return_Location']; ?>">

            <label>Total Rental Amount</label>
            <input type="number" step="0.01" name="total_rental_amount" value="<?php echo $booking['Total_Rental_Amount']; ?>" required>

            <label>Notes</label>
            <textarea name="notes"><?php echo $booking['Notes']; ?></textarea>

            <button type="submit" name="submit">
                Update Booking
            </button>

            <a href="booking_management.php">
                Back
            </a>

        </form>

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