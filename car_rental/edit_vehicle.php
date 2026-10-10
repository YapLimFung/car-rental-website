<?php

include "db.php";


$id = $_GET['id'];


$result = mysqli_query($conn, "SELECT * FROM Vehicle WHERE Vehicle_ID=$id");


$row = mysqli_fetch_assoc($result);



if (isset($_POST['submit'])) {


    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $seat = $_POST['seat'];
    $rate = $_POST['rate'];
    $status = $_POST['status'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $maintenance = $_POST['maintenance'];



    $sql = "UPDATE Vehicle SET

Brand='$brand',
Model='$model',
Category='$category',
Year='$year',
Seating_Capacity='$seat',
Rate_Type='$rate',
Current_Status='$status',
Image_URL='$image',
Description='$description',
Last_Maintenance='$maintenance'


WHERE Vehicle_ID=$id";


    mysqli_query($conn, $sql);


    header("Location: vehicle_management.php");
}


?>


<!DOCTYPE html>

<html>

<head>

    <title>Edit Vehicle</title>

    <link rel="stylesheet" href="css/vehicle.css">

</head>


<body>


    <div class="form-container">


        <h1>Edit Vehicle</h1>


        <form method="POST">


            <input type="text" value="<?php echo $row['Plate_Number']; ?>" disabled>


            <input type="text" name="brand" value="<?php echo $row['Brand']; ?>">


            <input type="text" name="model" value="<?php echo $row['Model']; ?>">



            <select name="category">

                <option><?php echo $row['Category']; ?></option>
                <option>Sedan</option>
                <option>SUV</option>
                <option>MPV</option>
                <option>Luxury</option>
                <option>Van</option>

            </select>



            <input type="number" name="year" value="<?php echo $row['Year']; ?>">


            <input type="number" name="seat" value="<?php echo $row['Seating_Capacity']; ?>">


            <input type="number" step="0.01" name="rate" value="<?php echo $row['Rate_Type']; ?>">



            <select name="status">

                <option><?php echo $row['Current_Status']; ?></option>
                <option>Available</option>
                <option>Rented</option>
                <option>Maintenance</option>

            </select>



            <input type="text" name="image" value="<?php echo $row['Image_URL']; ?>">


            <textarea name="description"><?php echo $row['Description']; ?></textarea>


            <input type="date" name="maintenance" value="<?php echo $row['Last_Maintenance']; ?>">



            <button name="submit">
                Update Vehicle
            </button>


            <a href="vehicle_management.php">
                Cancel
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