<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$message = "";
$messageColor = "green";

$users = mysqli_query($conn, "
    SELECT User.User_ID, User.First_Name, User.Last_Name, User.Email
    FROM User
    LEFT JOIN Customer ON User.User_ID = Customer.User_ID
    WHERE Customer.User_ID IS NULL
");

if (isset($_POST['submit'])) {

    // Get user details from form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $password = $_POST['password'];
    $id_passport = $_POST['id_passport'];
    $license_number = $_POST['license_number'];
    $license_expiry = $_POST['license_expiry'];
    $address = $_POST['address'];
    $emergency_contact = $_POST['emergency_contact'];
    $emergency_phone = $_POST['emergency_phone'];
    
    // Customer specific fields
    $membership_level = $_POST['membership_level'];
    $reward_points = $_POST['reward_points'];
    $customer_status = $_POST['customer_status'];

    // Validate required fields
    if(empty($first_name) || empty($last_name) || empty($email) || empty($contact_no) || empty($password)) {
        $message = "Please fill in all required fields (First Name, Last Name, Email, Contact No, Password)";
        $messageColor = "red";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT * FROM User WHERE Email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists! Please use a different email.";
            $messageColor = "red";
        } else {
            // Prepare optional fields (NULL if empty)
            $id_passport = empty($id_passport) ? "NULL" : "'$id_passport'";
            $license_number = empty($license_number) ? "NULL" : "'$license_number'";
            $license_expiry = empty($license_expiry) ? "NULL" : "'$license_expiry'";
            $address = empty($address) ? "NULL" : "'$address'";
            $emergency_contact = empty($emergency_contact) ? "NULL" : "'$emergency_contact'";
            $emergency_phone = empty($emergency_phone) ? "NULL" : "'$emergency_phone'";

            // Insert into User table
            $sql = "INSERT INTO `User` (
                `First_Name`, `Last_Name`, `Email`, `Contact_No`, `Password`,
                `ID_Passport`, `License_Number`, `License_Expiry`, 
                `Address`, `Emergency_Contact`, `Emergency_Phone`, `User_Type`
            ) VALUES (
                '$first_name', '$last_name', '$email', '$contact_no', '$password',
                $id_passport, $license_number, $license_expiry,
                $address, $emergency_contact, $emergency_phone, 'Customer'
            )";

            if ($conn->query($sql)) {
                $user_id = $conn->insert_id;

                // Insert into Customer table
                $stmt = $conn->prepare("INSERT INTO Customer
                (`User_ID`, `Membership_Level`, `Reward_Points`, `Customer_Status`)
                VALUES (?, ?, ?, ?)");

                $stmt->bind_param(
                    "isis",
                    $user_id,
                    $membership_level,
                    $reward_points,
                    $customer_status
                );

                if ($stmt->execute()) {
                    $message = "Customer registered successfully! User ID: " . $user_id;
                    $messageColor = "green";
                } else {
                    $message = "Error adding customer: " . $stmt->error;
                    $messageColor = "red";
                }
            } else {
                $message = "Error creating user: " . $conn->error;
                $messageColor = "red";
            }
        }
    }

    // Refresh the list of available users
    $users = mysqli_query($conn, "
        SELECT User.User_ID, User.First_Name, User.Last_Name, User.Email
        FROM User
        LEFT JOIN Customer ON User.User_ID = Customer.User_ID
        WHERE Customer.User_ID IS NULL
    ");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Add Customer</h1>

        <?php if ($message != "") { ?>
            <p style="color: <?php echo $messageColor; ?>;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>First Name *</label>
            <input type="text" name="first_name" required>

            <label>Last Name *</label>
            <input type="text" name="last_name" required>

            <label>Email *</label>
            <input type="email" name="email" required>

            <label>Contact No *</label>
            <input type="text" name="contact_no" required>

            <label>Password *</label>
            <input type="password" name="password" required>

            <label>ID/Passport</label>
            <input type="text" name="id_passport">

            <label>License Number</label>
            <input type="text" name="license_number">

            <label>License Expiry</label>
            <input type="date" name="license_expiry">

            <label>Address</label>
            <textarea name="address" rows="3"></textarea>

            <label>Emergency Contact</label>
            <input type="text" name="emergency_contact">

            <label>Emergency Phone</label>
            <input type="text" name="emergency_phone">

            <label>Membership Level</label>
            <select name="membership_level">
                <option value="Normal">Normal</option>
                <option value="Silver">Silver</option>
                <option value="Gold">Gold</option>
                <option value="Platinum">Platinum</option>
            </select>

            <label>Reward Points</label>
            <input type="number" name="reward_points" value="0">

            <label>Customer Status</label>
            <select name="customer_status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <button type="submit" name="submit">
                Register Customer
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