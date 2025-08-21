<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/auth.php';

// Fetch stats
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Eye Zone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .stat-icon {
            font-size: 2rem;
            color: #764ba2;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">👓 Eye Zone Admin</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <div class="dashboard-title">Welcome, Admin!</div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <a href="view_users.php" style="text-decoration: none; color: inherit;">
                    <div class="card text-center p-3" style="cursor: pointer;">
                        <div class="stat-icon mb-2"><i class="bi bi-people-fill"></i></div>
                        <h5>Users</h5>
                        <p class="fs-4 fw-bold"><?php echo $user_count; ?></p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="view_products.php" style="text-decoration: none; color: inherit;">
                    <div class="card text-center p-3 hover-shadow" style="cursor: pointer;">
                        <div class="stat-icon mb-2"><i class="bi bi-eyeglasses"></i></div>
                        <h5>Products</h5>
                        <p class="fs-4 fw-bold"><?php echo $product_count; ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="view_orders.php" style="text-decoration: none; color: inherit;">
                    <div class="card text-center p-3" style="cursor: pointer;">
                        <div class="stat-icon mb-2"><i class="bi bi-receipt"></i></div>
                        <h5>Orders</h5>
                        <p class="fs-4 fw-bold"><?php echo $order_count; ?></p>
                    </div>
                </a>
            </div>

        </div>

        <div class="card p-4">
            <h4 class="mb-3">Quick Actions</h4>
            <div class="d-flex flex-wrap gap-3">
                <a href="add_product.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
                <!-- <a href="view_products.php" class="btn btn-secondary"><i class="bi bi-card-list"></i> View Products</a> -->
                <!-- <a href="view_users.php" class="btn btn-outline-dark me-2">👤 View Users</a> -->
                <a href="view_orders.php" class="btn btn-success"><i class="bi bi-box-seam"></i> View Orders</a>
                <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>