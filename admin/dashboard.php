<?php
include 'partials/header.php';
include '../includes/db.php';

// Fetch stats using prepared statements
$stmt_users = $conn->prepare("SELECT COUNT(*) AS total FROM users");
$stmt_users->execute();
$user_count = $stmt_users->get_result()->fetch_assoc()['total'];
$stmt_users->close();

$stmt_products = $conn->prepare("SELECT COUNT(*) AS total FROM products");
$stmt_products->execute();
$product_count = $stmt_products->get_result()->fetch_assoc()['total'];
$stmt_products->close();

$stmt_orders = $conn->prepare("SELECT COUNT(*) AS total FROM orders");
$stmt_orders->execute();
$order_count = $stmt_orders->get_result()->fetch_assoc()['total'];
$stmt_orders->close();
?>

<h1 class="section-title-admin">Dashboard</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-admin text-center p-3">
            <div class="display-4 text-primary mb-3"><i class="bi bi-people-fill"></i></div>
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text fs-4 fw-bold"><?php echo $user_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-admin text-center p-3">
            <div class="display-4 text-success mb-3"><i class="bi bi-eyeglasses"></i></div>
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <p class="card-text fs-4 fw-bold"><?php echo $product_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-admin text-center p-3">
            <div class="display-4 text-info mb-3"><i class="bi bi-receipt"></i></div>
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text fs-4 fw-bold"><?php echo $order_count; ?></p>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>