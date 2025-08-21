<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = $conn->prepare("UPDATE users SET name=?, email=?, phone=? WHERE id=?");
    $query->execute([$name, $email, $phone, $id]);

    // Redirect back to profile page
    header("Location: profile.php?success=1");
    exit;
}
?>
