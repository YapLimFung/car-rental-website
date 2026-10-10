<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$message = "";
$messageColor = "green";

$users = mysqli_query($conn, "SELECT User_ID FROM User");
$vehicles = mysqli_query($conn, "SELECT Vehicle_ID, Brand, Model, Plate_Number FROM Vehicle");
$staffs = mysqli_query($conn, "SELECT Staff_ID FROM Staff");

if (isset($_POST['submit'])) {

    $customer_id = $_POST['customer_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $booking_status = $_POST['booking_status'];
    $rental_start_date = $_POST['rental_start_date'];
    $rental_end_date = $_POST['rental_end_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $total_rental_amount = $_POST['total_rental_amount'];
    $notes = $_POST['notes'];

    $staff_attended_id = $_POST['staff_attended_id'];
    $staff_service_id = $_POST['staff_service_id'];

    if ($staff_attended_id == "") {
        $staff_attended_id = NULL;
    }

    if ($staff_service_id == "") {
        $staff_service_id = NULL;
    }

    $stmt = $conn->prepare("INSERT INTO Booking
    (`Customer_ID`, `Vehicle_ID`, `Booking_Status`, `Rental_Start_Date`, `Rental_End_Date`, `Pickup_Location`, `Return_Location`, `Total_Rental_Amount`, `Notes`, `Staff_Attended_ID`, `Staff_Service_ID`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "iisssssdsii",
        $customer_id,
        $vehicle_id,
        $booking_status,
        $rental_start_date,
        $rental_end_date,
        $pickup_location,
        $return_location,
        $total_rental_amount,
        $notes,
        $staff_attended_id,
        $staff_service_id
    );

    if ($stmt->execute()) {
        $message = "Booking added successfully!";
        $messageColor = "green";
    } else {
        $message = "Error adding booking: " . $stmt->error;
        $messageColor = "red";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking</title>
    <link rel="stylesheet" href="css/vehicle.css">

</head>

<body>

    <div class="form-container">

        <h1>Add Booking</h1>

        <?php if ($message != "") { ?>
            <p style="color: <?php echo $messageColor; ?>;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Customer</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>

                <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                    <option value="<?php echo $user['User_ID']; ?>">
                        User ID: <?php echo $user['User_ID']; ?>
                    </option>
                <?php } ?>

            </select>

            <label>Vehicle</label>
            <select name="vehicle_id" required>
                <option value="">Select Vehicle</option>

                <?php while ($vehicle = mysqli_fetch_assoc($vehicles)) { ?>
                    <option value="<?php echo $vehicle['Vehicle_ID']; ?>">
                        <?php echo $vehicle['Vehicle_ID']; ?> -
                        <?php echo $vehicle['Brand']; ?>
                        <?php echo $vehicle['Model']; ?>
                        (<?php echo $vehicle['Plate_Number']; ?>)
                    </option>
                <?php } ?>

            </select>

            <label>Booking Status</label>
            <select name="booking_status" required>
                <option value="Confirmed">Confirmed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Completed">Completed</option>
            </select>

            <label>Rental Start Date</label>
            <input type="date" name="rental_start_date" required>

            <label>Rental End Date</label>
            <input type="date" name="rental_end_date" required>

            <label>Pickup Location</label>
            <input type="text" name="pickup_location" required>

            <label>Return Location</label>
            <input type="text" name="return_location">

            <label>Total Rental Amount</label>
            <input type="number" step="0.01" name="total_rental_amount" required>

            <label>Notes</label>
            <textarea name="notes"></textarea>

            <label>Staff Attended</label>
            <select name="staff_attended_id">
                <option value="">No Staff</option>

                <?php while ($staff = mysqli_fetch_assoc($staffs)) { ?>
                    <option value="<?php echo $staff['Staff_ID']; ?>">
                        Staff ID: <?php echo $staff['Staff_ID']; ?>
                    </option>
                <?php } ?>

            </select>

            <?php
            $staffs2 = mysqli_query($conn, "SELECT Staff_ID FROM Staff");
            ?>

            <label>Staff Service</label>
            <select name="staff_service_id">
                <option value="">No Staff</option>

                <?php while ($staff2 = mysqli_fetch_assoc($staffs2)) { ?>
                    <option value="<?php echo $staff2['Staff_ID']; ?>">
                        Staff ID: <?php echo $staff2['Staff_ID']; ?>
                    </option>
                <?php } ?>

            </select>

            <button type="submit" name="submit">
                Add Booking
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