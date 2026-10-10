<?php
session_start();
include "db.php";

$vehicle_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM `Vehicle` WHERE `Vehicle_ID` = $vehicle_id";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    header("Location: vehicle_listing.php");
    exit();
}

$vehicle = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vehicle['Brand'] . ' ' . $vehicle['Model']; ?> - ATAS Car Rental</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        /*header section*/

header{
    top: 0;
    
}

.logo{
    width: 120px;
}

.header-container{
    display: flex;
    background-color: black;
    justify-content: space-between;
    align-items: center;
}

.header-container ul{
    list-style-type: none;
    margin: 0;
    gap: 20px;
    padding: 20px;
    display: flex;
}

.header-container ul li a{
    text-decoration: none;
    color: white;
    font-size: 18px;
}


/*footer section*/
footer{
    background-color: black;
    color: white;
    text-align: center;
    padding: 20px;
}

.logo-footer{
    width: 150px;
}

.footer-section{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
}

.footer-section2{
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    gap:50px;
    padding: 20px;
}


.footer-content{
    display: flex;
    flex-direction: column;
    gap: 10px;
    text-align: left;
}

.logotext{
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-logo-text a{
    text-decoration: none;
    color: white;
    padding: 10px;
    gap:20px;
}

.footer-content a{
    text-decoration: none;
    color: white;
    font-size: 15px;}

        /*header*/
        .header {
            background: #1a1a1a;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #c9a84c;
        }
        .header h1 span {
            color: white;
        }
        .header a {
            color: white;
            text-decoration: none;
        }
        .header a:hover {
            color: #c9a84c;
        }
 
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            .detail-grid {
                grid-template-columns: 1fr;
            }
            .btn-group {
                flex-direction: column;
            }
            .vehicle-content {
                padding: 20px;
            }
        }
    </style>
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
                <a href="login.php" class="login-button">Login</a>
        </div>
        <hr>
    </header>

    <div class="container">
        <a href="vehicle_listing.php" class="back-link">← Back to Fleet</a>

        <div class="vehicle-detail">
            <div class="vehicle-image">
                <div>
                    <div class="icon">🚗</div>
                    <div class="label"><?php echo $vehicle['Brand'] . ' ' . $vehicle['Model']; ?></div>
                </div>
            </div>

            <div class="vehicle-content">
                <h2><?php echo $vehicle['Brand'] . ' ' . $vehicle['Model']; ?></h2>
                <div class="plate"><?php echo $vehicle['Plate_Number']; ?></div>

                <span class="status status-<?php echo strtolower($vehicle['Current_Status']); ?>">
                    <?php echo $vehicle['Current_Status']; ?>
                </span>

                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Category</label>
                        <div class="value"><?php echo $vehicle['Category']; ?></div>
                    </div>
                    <div class="detail-item">
                        <label>Year</label>
                        <div class="value"><?php echo $vehicle['Year']; ?></div>
                    </div>
                    <div class="detail-item">
                        <label>Seating Capacity</label>
                        <div class="value"><?php echo $vehicle['Seating_Capacity']; ?> seats</div>
                    </div>
                    <div class="detail-item">
                        <label>Last Maintenance</label>
                        <div class="value"><?php echo $vehicle['Last_Maintenance'] ? date('d M Y', strtotime($vehicle['Last_Maintenance'])) : 'N/A'; ?></div>
                    </div>
                </div>

                <?php if($vehicle['Description']): ?>
                    <div style="margin: 15px 0; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                        <p style="color: #666; line-height: 1.6;"><?php echo $vehicle['Description']; ?></p>
                    </div>
                <?php endif; ?>

                <div class="price-box">
                    <div class="price">RM <?php echo number_format($vehicle['Rate_Type'], 2); ?> <small>/ day</small></div>
                </div>

                <div class="btn-group">
                    <?php if($vehicle['Current_Status'] == 'Available'): ?>
                        <a href="booking.php?vehicle_id=<?php echo $vehicle['Vehicle_ID']; ?>" class="btn btn-primary">Book Now</a>
                    <?php else: ?>
                        <button class="btn btn-primary" disabled>Not Available</button>
                    <?php endif; ?>
                    <a href="vehicle_listing.php" class="btn btn-secondary">Browse More</a>
                </div>
            </div>
        </div>
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