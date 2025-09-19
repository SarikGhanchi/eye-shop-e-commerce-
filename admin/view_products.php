<?php
include 'partials/header.php';
include '../includes/db.php';

// Fetch all products
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="section-title-admin">All Products</h1>

<div class="d-flex justify-content-end mb-3">
    <a href="add_product.php" class="btn btn-admin-primary"><i class="bi bi-plus-circle me-2"></i>Add New Product</a>
</div>

<div class="card card-admin shadow mb-4">
    <div class="card-header-admin py-3">
        <h6 class="m-0 fw-bold">Product List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-admin" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><img src="../assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" width="60" class="rounded"></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>