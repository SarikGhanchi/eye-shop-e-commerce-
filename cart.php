<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle AJAX requests for cart updates
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $product_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($action === 'add') {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            $_SESSION['cart'][$product_id] += $quantity;
        }
        echo json_encode(['status' => 'success', 'cart_count' => count($_SESSION['cart'])]);
        exit();
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$product_id]);
        echo json_encode(['status' => 'success', 'cart_count' => count($_SESSION['cart'])]);
        exit();
    } elseif ($action === 'update_quantity') {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
        echo json_encode(['status' => 'success', 'cart_count' => count($_SESSION['cart'])]);
        exit();
    }
}

// Fetch cart items for display
$cart_products = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($product_ids)");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($product = $result->fetch_assoc()) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $total += $product['subtotal'];
        $cart_products[] = $product;
    }
}
?>

<div class="container my-5">
    <h2 class="section-title">Your Shopping Cart</h2>

    <?php if (empty($cart_products)): ?>
        <div class="empty-state alert alert-info text-center py-5">
            <i class="bi bi-cart-x display-4 text-info mb-3"></i>
            <h3 class="mt-3">Your Cart is Empty</h3>
            <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
            <a href="index.php" class="btn btn-primary mt-3">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <?php foreach ($cart_products as $product): ?>
                    <div class="card cart-item-card mb-3">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3">
                                <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded-start cart-item-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text text-muted">$<?php echo number_format($product['price'], 2); ?></p>
                                    <div class="d-flex align-items-center">
                                        <input type="number" class="form-control quantity-input me-2" data-product-id="<?php echo $product['id']; ?>" value="<?php echo $product['quantity']; ?>" min="1" style="width: 80px;">
                                        <button class="btn btn-outline-danger btn-sm remove-from-cart" data-product-id="<?php echo $product['id']; ?>">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-4">
                <div class="card cart-summary-card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Order Summary</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal
                                <span>$<?php echo number_format($total, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Shipping
                                <span class="text-success">FREE</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                Total
                                <span>$<?php echo number_format($total, 2); ?></span>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 mt-4">
                            <a href="checkout.php" class="btn btn-primary btn-lg">Proceed to Checkout</a>
                            <a href="index.php" class="btn btn-outline-secondary btn-lg">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>