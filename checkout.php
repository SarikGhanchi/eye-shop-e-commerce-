<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container my-5'><div class='alert alert-warning text-center'>You must <a href='login.php' class='alert-link'>login</a> to place an order.</div></div>";
    include 'includes/footer.php';
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<div class='container my-5'><div class='alert alert-info text-center'>Your cart is empty. <a href='index.php' class='alert-link'>Shop Now</a></div></div>";
    include 'includes/footer.php';
    exit();
}

$total = 0;
$cart_products = [];

// Fetch product details for items in cart using prepared statements
if (!empty($cart)) {
    $product_ids = implode(',', array_keys($cart));
    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($product_ids)");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($product = $result->fetch_assoc()) {
        $product['quantity'] = $cart[$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $total += $product['subtotal'];
        $cart_products[] = $product;
    }
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->bind_param("id", $user_id, $total); // 'd' for double (float)
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    if ($order_id) {
        // Insert order items
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart_products as $item) {
            $pid = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $stmt_item->bind_param("iiid", $order_id, $pid, $quantity, $price);
            $stmt_item->execute();
        }
        $stmt_item->close();

        unset($_SESSION['cart']);
        echo "<div class='container my-5'><div class='alert alert-success text-center'>✅ Order placed successfully! <br><a href='index.php' class='btn btn-sm btn-success mt-3'>Continue Shopping</a></div></div>";
        include 'includes/footer.php';
        exit();
    } else {
        echo "<div class='container my-5'><div class='alert alert-danger text-center'>❌ Failed to place order. Try again.</div></div>";
        include 'includes/footer.php';
        exit();
    }
}
?>

<div class="container my-5">
    <h2 class="section-title">Checkout</h2>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">Order Summary</h4>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mb-4">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_products as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                            <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <form method="POST" class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-check-circle me-2"></i>Confirm & Place Order
                </button>
                <a href="cart.php" class="btn btn-outline-secondary btn-lg px-4 ms-2">
                    <i class="bi bi-arrow-left me-2"></i>Back to Cart
                </a>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>