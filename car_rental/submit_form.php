<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    try {

        $sql = "INSERT INTO contact_messages
                (full_name, email, phone, subject, message)
                VALUES
                (:name, :email, :phone, :subject, :message)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':subject' => $subject,
            ':message' => $message
        ]);

        echo "<h2>Thank You!</h2>";
        echo "<p>Your message has been submitted successfully.</p>";
        echo "<a href='contact.html'>Return to Contact Page</a>";

    } catch (PDOException $e) {

        die("Error: " . $e->getMessage());

    }

} else {

    header("Location: contact.html");
    exit();

}
?>