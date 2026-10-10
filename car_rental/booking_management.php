<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$search = "";
$status = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$sql = "SELECT 
            Booking.Booking_ID,
            Booking.Customer_ID,
            Booking.Rental_Start_Date,
            Booking.Rental_End_Date,
            Booking.Total_Rental_Amount,
            Booking.Booking_Status,
            Booking.Pickup_Location,
            Booking.Return_Location,
            Vehicle.Brand,
            Vehicle.Model,
            Vehicle.Plate_Number
        FROM Booking
        JOIN Vehicle ON Booking.Vehicle_ID = Vehicle.Vehicle_ID
        WHERE 1";

if ($search != "") {
    $sql .= " AND (
        Booking.Customer_ID LIKE '%$search%' OR
        Vehicle.Brand LIKE '%$search%' OR
        Vehicle.Model LIKE '%$search%' OR
        Vehicle.Plate_Number LIKE '%$search%' OR
        Booking.Pickup_Location LIKE '%$search%' OR
        Booking.Return_Location LIKE '%$search%'
    )";
}

if ($status != "") {
    $sql .= " AND Booking.Booking_Status = '$status'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
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

                <a href="dashboard.php">
                    Dashboard
                </a>

                <a href="vehicle_management.php">
                    Vehicle Management
                </a>

                <a href="booking_management.php" class="active">
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
                    Booking Management
                </h1>

                <a href="add_booking.php">
                    <button class="add-btn">
                        + Add Booking
                    </button>
                </a>

            </div>

            <form method="GET" action="booking_management.php">

                <div class="filter-section">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search Booking"
                        value="<?php echo $search; ?>">

                    <select name="status">
                        <option value="">All Status</option>

                        <option value="Confirmed" <?php if ($status == "Confirmed") echo "selected"; ?>>
                            Confirmed
                        </option>

                        <option value="Pending" <?php if ($status == "Pending") echo "selected"; ?>>
                            Pending
                        </option>

                        <option value="Cancelled" <?php if ($status == "Cancelled") echo "selected"; ?>>
                            Cancelled
                        </option>

                        <option value="Completed" <?php if ($status == "Completed") echo "selected"; ?>>
                            Completed
                        </option>
                    </select>

                    <button type="submit" class="edit">
                        Search
                    </button>

                    <a href="booking_management.php">
                        <button type="button" class="delete">
                            Reset
                        </button>
                    </a>

                </div>

            </form>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>Booking ID</th>
                            <th>Customer ID</th>
                            <th>Vehicle</th>
                            <th>Plate No</th>
                            <th>Rental Start</th>
                            <th>Rental End</th>
                            <th>Pickup</th>
                            <th>Return</th>
                            <th>Total Rental</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                        ?>

                                <tr>

                                    <td>
                                        <?php echo $row['Booking_ID']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Customer_ID']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Brand'] . " " . $row['Model']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Plate_Number']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Rental_Start_Date']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Rental_End_Date']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Pickup_Location']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Return_Location']; ?>
                                    </td>

                                    <td>
                                        RM<?php echo number_format($row['Total_Rental_Amount'], 2); ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Booking_Status']; ?>
                                    </td>

                                    <td>

                                        <a href="view_booking.php?id=<?php echo $row['Booking_ID']; ?>">
                                            <button class="view">
                                                View
                                            </button>
                                        </a>

                                        <a href="edit_booking.php?id=<?php echo $row['Booking_ID']; ?>">
                                            <button class="edit">
                                                Edit
                                            </button>
                                        </a>

                                        <a href="delete_booking.php?id=<?php echo $row['Booking_ID']; ?>">
                                            <button class="delete">
                                                Delete
                                            </button>
                                        </a>

                                    </td>

                                </tr>

                            <?php

                            }
                        } else {

                            ?>

                            <tr>
                                <td colspan="11">
                                    No bookings found.
                                </td>
                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

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