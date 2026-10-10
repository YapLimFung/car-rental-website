<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$search = "";
$status = "";
$type = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

$sql = "SELECT * FROM Vehicle WHERE 1";

if ($search != "") {
    $sql .= " AND (Brand LIKE '%$search%' 
              OR Model LIKE '%$search%' 
              OR Plate_Number LIKE '%$search%')";
}

if ($status != "") {
    $sql .= " AND Current_Status = '$status'";
}

if ($type != "") {
    $sql .= " AND Category = '$type'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management</title>
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

                <a href="vehicle_management.php" class="active">
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
                    Vehicle Management
                </h1>

                <a href="add_vehicle.php">
                    <button class="add-btn">
                        + Add Vehicle
                    </button>
                </a>

            </div>

            <form method="GET" action="vehicle_management.php">

                <div class="filter-section">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search Vehicle"
                        value="<?php echo $search; ?>">

                    <select name="status">
                        <option value="">All Status</option>

                        <option value="Available" <?php if ($status == "Available") echo "selected"; ?>>
                            Available
                        </option>

                        <option value="Rented" <?php if ($status == "Rented") echo "selected"; ?>>
                            Rented
                        </option>

                        <option value="Maintenance" <?php if ($status == "Maintenance") echo "selected"; ?>>
                            Maintenance
                        </option>
                    </select>

                    <select name="type">
                        <option value="">All Types</option>

                        <option value="Sedan" <?php if ($type == "Sedan") echo "selected"; ?>>
                            Sedan
                        </option>

                        <option value="SUV" <?php if ($type == "SUV") echo "selected"; ?>>
                            SUV
                        </option>

                        <option value="MPV" <?php if ($type == "MPV") echo "selected"; ?>>
                            MPV
                        </option>

                        <option value="Luxury" <?php if ($type == "Luxury") echo "selected"; ?>>
                            Luxury
                        </option>

                        <option value="Van" <?php if ($type == "Van") echo "selected"; ?>>
                            Van
                        </option>
                    </select>

                    <button type="submit" class="edit">
                        Search
                    </button>

                    <a href="vehicle_management.php">
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
                            <th>Vehicle ID</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Plate No</th>
                            <th>Status</th>
                            <th>Daily Rate</th>
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
                                        <?php echo $row['Vehicle_ID']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Brand']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Model']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Category']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Plate_Number']; ?>
                                    </td>

                                    <td>

                                        <?php

                                        if ($row['Current_Status'] == "Available") {
                                            echo "<span class='available'>Available</span>";
                                        } elseif ($row['Current_Status'] == "Rented") {
                                            echo "<span class='rented'>Rented</span>";
                                        } else {
                                            echo "<span class='maintenance'>Maintenance</span>";
                                        }

                                        ?>

                                    </td>

                                    <td>
                                        RM<?php echo number_format($row['Rate_Type'], 2); ?>
                                    </td>

                                    <td>

                                        <a href="view_vehicle.php?id=<?php echo $row['Vehicle_ID']; ?>">
                                            <button class="view">
                                                View
                                            </button>
                                        </a>

                                        <a href="edit_vehicle.php?id=<?php echo $row['Vehicle_ID']; ?>">
                                            <button class="edit">
                                                Edit
                                            </button>
                                        </a>

                                        <a href="delete_vehicle.php?id=<?php echo $row['Vehicle_ID']; ?>">
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
                                <td colspan="8">
                                    No vehicles found.
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