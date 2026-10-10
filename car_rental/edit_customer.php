<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$message = "";
$messageColor = "green";

if (!isset($_GET['id'])) {
    header("Location: customer_management.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM Customer WHERE Customer_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Customer not found.";
    exit();
}

if (isset($_POST['submit'])) {

    $membership_level = $_POST['membership_level'];
    $reward_points = $_POST['reward_points'];
    $customer_status = $_POST['customer_status'];

    $update = $conn->prepare("UPDATE Customer SET
        Membership_Level = ?,
        Reward_Points = ?,
        Customer_Status = ?
        WHERE Customer_ID = ?");

    $update->bind_param(
        "sisi",
        $membership_level,
        $reward_points,
        $customer_status,
        $id
    );

    if ($update->execute()) {
        $message = "Customer updated successfully!";
        $messageColor = "green";

        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
    } else {
        $message = "Error updating customer: " . $update->error;
        $messageColor = "red";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Edit Customer</h1>

        <?php if ($message != "") { ?>
            <p style="color: <?php echo $messageColor; ?>;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>User ID</label>
            <input type="number" value="<?php echo $customer['User_ID']; ?>" disabled>

            <label>Membership Level</label>
            <select name="membership_level">
                <option value="Normal" <?php if ($customer['Membership_Level'] == "Normal") echo "selected"; ?>>
                    Normal
                </option>

                <option value="Silver" <?php if ($customer['Membership_Level'] == "Silver") echo "selected"; ?>>
                    Silver
                </option>

                <option value="Gold" <?php if ($customer['Membership_Level'] == "Gold") echo "selected"; ?>>
                    Gold
                </option>

                <option value="Platinum" <?php if ($customer['Membership_Level'] == "Platinum") echo "selected"; ?>>
                    Platinum
                </option>
            </select>

            <label>Reward Points</label>
            <input type="number" name="reward_points" value="<?php echo $customer['Reward_Points']; ?>" required>

            <label>Customer Status</label>
            <select name="customer_status">
                <option value="Active" <?php if ($customer['Customer_Status'] == "Active") echo "selected"; ?>>
                    Active
                </option>

                <option value="Inactive" <?php if ($customer['Customer_Status'] == "Inactive") echo "selected"; ?>>
                    Inactive
                </option>
            </select>

            <button type="submit" name="submit">
                Update Customer
            </button>

            <a href="customer_management.php">
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