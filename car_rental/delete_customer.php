<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: customer_management.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM Customer WHERE Customer_ID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: customer_management.php");
    exit();
} else {
    echo "Error deleting customer: " . $stmt->error;
}
?>