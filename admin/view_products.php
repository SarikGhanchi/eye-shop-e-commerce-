<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

// Fetch all products
$result = mysqli_query($conn, "SELECT * FROM products ");
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
            transition: 0.2s;
        }
    </style>

    <title>All Products - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2>📦 All Products</h2>
        <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

        <table class="table table-bordered table-hover bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (Rs)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;

                while ($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $index++; ?></td>
                        <td><img src="../assets/uploads/<?php echo $product['image']; ?>" width="60"></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td>
                            <a href="product_details.php?id=<?php echo $product['id']; ?>"
                                class="btn btn-info btn-sm">View</a>
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>