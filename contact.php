<?php
include 'includes/db.php';
include 'includes/header.php';

$name = $email = $message = "";
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $sql = "INSERT INTO contact_us (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = "Thank you! Your message has been sent.";
            // Clear form
            $name = $email = $message = "";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<h2>Contact Us</h2>

<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php elseif ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>

    <label>Message:</label><br>
    <textarea name="message" required><?php echo $message; ?></textarea><br><br>

    <input type="submit" value="Send Message">
</form>

<?php include 'includes/footer.php'; ?>
