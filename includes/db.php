<?php
// <?php
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "eye_shop";

// $conn = new mysqli($host, $username, $password, $database);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// ?>
<?php
$host = 'localhost';
$user = 'root';           // XAMPP default username
$password = '';           // XAMPP default password is empty
$dbname = 'eye_shop';    // Tumhara database name

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
