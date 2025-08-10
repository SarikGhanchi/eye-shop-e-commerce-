<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>


<?php
include '../includes/db.php';
include '../includes/auth.php'; // session check for admin

// Fetch stats
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Eye Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Admin Dashboard</h2>
<p>Welcome, Admin!</p>

<div style="display: flex; gap: 30px; margin-bottom: 20px;">
    <div>
        <h3>👤 Users</h3>
        <p>Total: <?php echo $user_count; ?></p>
    </div>
    <div>
        <h3>👓 Products</h3>
        <p>Total: <?php echo $product_count; ?></p>
    </div>
    <div>
        <h3>🧾 Orders</h3>
        <p>Total: <?php echo $order_count; ?></p>
    </div>
</div>

<h4>Quick Actions:</h4>
<ul>
    <li><a href="add_product.php">➕ Add Product</a></li>
    <li><a href="view_orders.php">📦 View Orders</a></li>
    <li><a href="logout.php">🔓 Logout</a></li>
</ul>

</body>
</html>
