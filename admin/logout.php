<?php
include '../includes/auth.php';
include '../includes/db.php';
// rest of your code
?>

<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
