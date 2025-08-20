<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>You must <a href='login.php'>login</a> to place an order.</p>";
    include 'includes/footer.php';
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>Your cart is empty. <a href='index.php'>Shop now</a></p>";
    include 'includes/footer.php';
    exit();
}

// ✅ Calculate total using DB
$total = 0;
$cart_products = [];

foreach ($cart as $product_id => $qty) {
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    if ($product = mysqli_fetch_assoc($res)) {
        $product['quantity'] = $qty;
        $product['subtotal'] = $product['price'] * $qty;
        $total += $product['subtotal'];
        $cart_products[] = $product;
    }
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $insert_order = "INSERT INTO orders (user_id, total) VALUES ('$user_id', '$total')";
    
    if (mysqli_query($conn, $insert_order)) {
        $order_id = mysqli_insert_id($conn);

        foreach ($cart_products as $item) {
            $pid = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES ('$order_id', '$pid', '$quantity', '$price')";
            mysqli_query($conn, $insert_item);
        }

        unset($_SESSION['cart']);
        echo "<p style='color:green;'>✅ Order placed successfully!</p>";
        echo "<p><a href='index.php'>Continue Shopping</a></p>";
        include 'includes/footer.php';
        exit();
    } else {
        echo "<p style='color:red;'>❌ Failed to place order. Try again.</p>";
    }
}
?>

<h2>Checkout</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>
    <?php foreach ($cart_products as $item): ?>
    <tr>
        <td><?php echo htmlspecialchars($item['name']); ?></td>
        <td>Rs. <?php echo $item['price']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>Rs. <?php echo $item['subtotal']; ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3"><strong>Grand Total</strong></td>
        <td><strong>Rs. <?php echo $total; ?></strong></td>
    </tr>
</table>

<br>

<form method="POST">
    <input type="submit" value="✅ Confirm & Place Order">
</form>

<?php include 'includes/footer.php'; ?>
