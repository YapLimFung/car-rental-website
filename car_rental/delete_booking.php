<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: booking_management.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM Booking WHERE Booking_ID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: booking_management.php");
    exit();
} else {
    echo "Error deleting booking: " . $stmt->error;
}
?>
