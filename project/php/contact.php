<?php
session_start();
require 'db.php';

if ($_SERVER["Contact_Submit"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    // Check if all fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<script>alert('All fields are required!'); window.location.href='http://localhost/Project%20Team%20Weaver/project/Implementation/Contact_page.html';</script>";
        exit();
    }

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM contact_form WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('User already exists! Try logging in.'); window.location.href='http://localhost/Project%20Team%20Weaver/project/Implementation/Contact_page.html';</script>";
        exit();
    }


    // Insert new user
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Message send Succesfully'); window.location.href='http://localhost/Project%20Team%20Weaver/project/Implementation/home.html';</script>";
    } else {
        echo "<script>alert('Failed. Please try again.'); window.location.href='http://localhost/Project%20Team%20Weaver/project/Implementation/Contact_page.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
