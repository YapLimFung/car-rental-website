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
            Customer.Customer_ID,
            Customer.User_ID,
            Customer.Membership_Level,
            Customer.Reward_Points,
            Customer.Customer_Status
        FROM Customer
        WHERE 1";

if ($search != "") {
    $sql .= " AND (
        Customer.Customer_ID LIKE '%$search%' OR
        Customer.User_ID LIKE '%$search%' OR
        Customer.Membership_Level LIKE '%$search%' OR
        Customer.Customer_Status LIKE '%$search%'
    )";
}

if ($status != "") {
    $sql .= " AND Customer.Customer_Status = '$status'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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

                <a href="booking_management.php">
                    Booking Management
                </a>

                <a href="customer_management.php" class="active">
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
                    Customer Management
                </h1>

                <a href="add_customer.php">
                    <button class="add-btn">
                        + Add Customer
                    </button>
                </a>

            </div>

            <form method="GET" action="customer_management.php">

                <div class="filter-section">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search Customer"
                        value="<?php echo $search; ?>">

                    <select name="status">
                        <option value="">All Status</option>

                        <option value="Active" <?php if ($status == "Active") echo "selected"; ?>>
                            Active
                        </option>

                        <option value="Inactive" <?php if ($status == "Inactive") echo "selected"; ?>>
                            Inactive
                        </option>
                    </select>

                    <button type="submit" class="edit">
                        Search
                    </button>

                    <a href="customer_management.php">
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
                            <th>Customer ID</th>
                            <th>User ID</th>
                            <th>Membership</th>
                            <th>Reward Points</th>
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
                                        <?php echo $row['Customer_ID']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['User_ID']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Membership_Level']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Reward_Points']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['Customer_Status']; ?>
                                    </td>

                                    <td>

                                        <a href="view_customer.php?id=<?php echo $row['Customer_ID']; ?>">
                                            <button class="view">
                                                View
                                            </button>
                                        </a>

                                        <a href="edit_customer.php?id=<?php echo $row['Customer_ID']; ?>">
                                            <button class="edit">
                                                Edit
                                            </button>
                                        </a>

                                        <a href="delete_customer.php?id=<?php echo $row['Customer_ID']; ?>" onclick="return confirm('Are you sure you want to delete this customer?');">
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
                                <td colspan="6">
                                    No customers found.
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