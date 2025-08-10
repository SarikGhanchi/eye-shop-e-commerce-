<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid Product ID.</p>";
    include 'includes/footer.php';
    exit();
}

$product_id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Product not found.</p>";
    include 'includes/footer.php';
    exit();
}

$product = mysqli_fetch_assoc($result);
?>

<h2><?php echo $product['name']; ?></h2>

<img src="assets/uploads/<?php echo $product['image']; ?>" alt="Product Image" width="200"><br><br>

<p><strong>Price:</strong> Rs. <?php echo $product['price']; ?></p>
<p><strong>Description:</strong> <?php echo $product['description']; ?></p>

<a href="cart.php?action=add&id=<?php echo $product['id']; ?>">Add to Cart</a>

<br><br>
<a href="index.php">← Back to Home</a>

<?php include 'includes/footer.php'; ?>
