<?php

include "db.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$message = "";
$messageColor = "green";

if (isset($_POST['submit'])) {

    try {
        $plate = $_POST['plate'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $category = $_POST['category'];
        $year = (int) $_POST['year'];
        $seat = (int) $_POST['seat'];
        $rate = (float) $_POST['rate'];
        $status = $_POST['status'];
        $image = $_POST['image'];
        $description = $_POST['description'];
        $maintenance = $_POST['maintenance'];

        $stmt = $conn->prepare("INSERT INTO Vehicle
        (`Plate_Number`, `Brand`, `Model`, `Category`, `Year`, `Seating_Capacity`, `Rate_Type`, `Current_Status`, `Image_URL`, `Description`, `Last_Maintenance`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssiidssss",
            $plate,
            $brand,
            $model,
            $category,
            $year,
            $seat,
            $rate,
            $status,
            $image,
            $description,
            $maintenance
        );

        $stmt->execute();

        $message = "Vehicle added successfully!";
        $messageColor = "green";

    } catch (Exception $e) {
        $message = "Database error: " . $e->getMessage();
        $messageColor = "red";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>

<body>

    <div class="form-container">

        <h1>Add Vehicle</h1>

        <?php if ($message != "") { ?>
            <p style="color: <?php echo $messageColor; ?>; font-weight: bold;">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST" action="">

            <div class="form-grid">

                <div>
                    <label>Plate Number</label>
                    <input type="text" name="plate" required>
                </div>

                <div>
                    <label>Brand</label>
                    <input type="text" name="brand" required>
                </div>

                <div>
                    <label>Model</label>
                    <input type="text" name="model" required>
                </div>

                <div>
                    <label>Category</label>
                    <select name="category" required>
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                        <option value="Luxury">Luxury</option>
                        <option value="Van">Van</option>
                    </select>
                </div>

                <div>
                    <label>Year</label>
                    <input type="number" name="year" min="2000" max="2035" required>
                </div>

                <div>
                    <label>Seats</label>
                    <input type="number" name="seat" min="2" max="20" required>
                </div>

                <div>
                    <label>Daily Rate (RM)</label>
                    <input type="number" step="0.01" name="rate" required>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Available">Available</option>
                        <option value="Rented">Rented</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

            </div>

            <label>Vehicle Image URL</label>
            <input
                type="url"
                name="image"
                id="image"
                placeholder="https://example.com/car.jpg"
                onkeyup="previewImage()">

            <img
                id="preview"
                style="width:100%;max-height:220px;object-fit:cover;border-radius:12px;margin:15px 0;display:none;"
                alt="Vehicle Preview">

            <label>Description</label>
            <textarea name="description" rows="5"></textarea>

            <label>Last Maintenance</label>
            <input type="date" name="maintenance" required>

            <div class="form-actions">
                <button type="submit" name="submit" value="1">
                    Add Vehicle
                </button>

                <a href="vehicle_management.php" class="cancel-btn">
                    Back
                </a>
            </div>

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