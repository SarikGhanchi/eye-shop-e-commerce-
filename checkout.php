<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container mt-5'>
            <div class='alert alert-warning text-center'>
                You must <a href='login.php' class='alert-link'>login</a> to place an order.
            </div>
          </div>";
    include 'includes/footer.php';
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<div class='container mt-5'>
            <div class='alert alert-info text-center'>
                Your cart is empty. <a href='index.php' class='alert-link'>Shop Now</a>
            </div>
          </div>";
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
        echo "<div class='container mt-5'>
                <div class='alert alert-success text-center'>
                    ✅ Order placed successfully! <br>
                    <a href='index.php' class='btn btn-sm btn-success mt-3'>Continue Shopping</a>
                </div>
              </div>";
        include 'includes/footer.php';
        exit();
    } else {
        echo "<div class='container mt-5'>
                <div class='alert alert-danger text-center'>
                    ❌ Failed to place order. Try again.
                </div>
              </div>";
    }
}
?>

<!-- <style>
    .sarik {
        background-color: #764ba2;
        border-color: rgba(118, 75, 162, 1);
    }
</style> -->

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center">
            <h3 class="mb-0 sarik ">Checkout</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Grand Total</strong></td>
                            <td><strong>₹<?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <form method="POST" class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg px-4">
                    ✅ Confirm & Place Order
                </button>
                <a href="cart.php" class="btn btn-outline-secondary btn-lg px-4 ms-2">
                    🛒 Back to Cart
                </a>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
