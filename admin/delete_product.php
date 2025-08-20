<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

// Check for valid product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid product ID.");
}

$product_id = intval($_GET['id']);

// Fetch product to get image name
$product_result = mysqli_query($conn, "SELECT image FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($product_result);

if (!$product) {
    die("❌ Product not found.");
}

// Delete image file if it exists
$image_path = "../assets/uploads/" . $product['image'];
if (file_exists($image_path)) {
    unlink($image_path);
}

// Delete product from database
$delete_result = mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");

if ($delete_result) {
    // Redirect back to view products page
    header("Location: view_products.php?deleted=1");
    exit();
} else {
    echo "❌ Error deleting product: " . mysqli_error($conn);
}
?>
