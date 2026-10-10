<?php
session_start();
include "db.php";

$error = "";
$success = "";

if(isset($_POST['submit'])) {
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
    $employee_id = $_POST['employee_id'];
    $hire_date = $_POST['hire_date'];
    $position = $_POST['position'];
    
    if(empty($first_name) || empty($last_name) || empty($email) || empty($contact_no) || empty($password) || empty($employee_id) || empty($hire_date) || empty($position)) {
        $error = "Please fill in all required fields";
    } else {
        $check = "SELECT * FROM `User` WHERE `Email` = '$email'";
        $result = $conn->query($check);
        
        if($result->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            $check_emp = "SELECT * FROM `Staff` WHERE `Employee_ID` = '$employee_id'";
            $result_emp = $conn->query($check_emp);
            
            if($result_emp->num_rows > 0) {
                $error = "Employee ID already exists!";
            } else {
                $id_passport = empty($id_passport) ? "NULL" : "'$id_passport'";
                $license_number = empty($license_number) ? "NULL" : "'$license_number'";
                $license_expiry = empty($license_expiry) ? "NULL" : "'$license_expiry'";
                $address = empty($address) ? "NULL" : "'$address'";
                $emergency_contact = empty($emergency_contact) ? "NULL" : "'$emergency_contact'";
                $emergency_phone = empty($emergency_phone) ? "NULL" : "'$emergency_phone'";
                
                $sql = "INSERT INTO `User` (
                    `First_Name`, `Last_Name`, `Email`, `Contact_No`, `Password`,
                    `ID_Passport`, `License_Number`, `License_Expiry`, 
                    `Address`, `Emergency_Contact`, `Emergency_Phone`, `User_Type`
                ) VALUES (
                    '$first_name', '$last_name', '$email', '$contact_no', '$password',
                    $id_passport, $license_number, $license_expiry,
                    $address, $emergency_contact, $emergency_phone, 'Staff'
                )";
                
                if($conn->query($sql)) {
                    $user_id = $conn->insert_id;
                    
                    $staff_sql = "INSERT INTO `Staff` (
                        `User_ID`, `Employee_ID`, `Hire_Date`, `Position`
                    ) VALUES (
                        $user_id, '$employee_id', '$hire_date', '$position'
                    )";
                    
                    if($conn->query($staff_sql)) {
                        $success = "Staff registered successfully!";
                    } else {
                        $error = "Error adding staff: " . $conn->error;
                    }
                } else {
                    $error = "Error: " . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/register.css" rel="stylesheet">
    <title>ATAS Car Rental - Register Staff</title>
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

<div class="register-container">

    <h2>Register Staff Account</h2>

    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if($success): ?>
        <p class="success"><?php echo $success; ?></p>
        <br>
        <a href="register_staff.php" class="login-here">Register Another</a>
        <a href="dashboard.php" class="login-here">Go to Dashboard</a>
    <?php endif; ?>

    <?php if(!$success): ?>
    <form method="post" action="register_staff.php">
        <div class="form-group">
            <label>First Name*</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="form-group">
            <label>Last Name*</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="form-group">
            <label>Email*</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Contact No*</label>
            <input type="text" name="contact_no" required>
        </div>
        <div class="form-group">
            <label>Password*</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Employee ID*</label>
            <input type="text" name="employee_id" required>
        </div>

        <div class="form-group">
            <label>Hire Date*</label>
            <input type="date" name="hire_date" required>
        </div>

        <div class="form-group">
            <label>Position*</label>
            <select name="position" required>
                <option value="">Select Position</option>
                <option value="System Administrator">System Administrator</option>
                <option value="Customer Service">Customer Service</option>
                <option value="Rental Agent">Intern</option>
                <option value="Accountant">Accountant</option>
                <option value="Mechanic">Mechanic</option>
            </select>
        </div>

        <div class="form-group">
            <label>ID/Passport</label>
            <input type="text" name="id_passport">
        </div>

        <div class="form-group">
            <label>License Number</label>
            <input type="text" name="license_number">
        </div>

        <div class="form-group">
            <label>License Expiry</label>
            <input type="date" name="license_expiry">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Emergency Contact</label>
            <input type="text" name="emergency_contact">
        </div>

        <div class="form-group">
            <label>Emergency Phone</label>
            <input type="text" name="emergency_phone">
        </div>

        <input class="submit-btn" type="submit" name="submit" value="Register Staff">
    </form>

    <br>
    <p><a href="dashboard.php" class="login-here">Back to Dashboard</a></p>
    
    <?php endif; ?>
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