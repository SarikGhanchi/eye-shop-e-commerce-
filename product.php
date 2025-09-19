<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container my-5'><div class='alert alert-danger text-center'>Invalid Product ID.</div></div>";
    include 'includes/footer.php';
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product details using prepared statement
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='container my-5'><div class='alert alert-warning text-center'>Product not found.</div></div>";
    include 'includes/footer.php';
    exit();
}

$product = $result->fetch_assoc();

// Fetch related products using prepared statement
$related_stmt = $conn->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4");
$related_stmt->bind_param("si", $product['category'], $product_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>

<div class="container my-5">
    <div class="row product-detail-row">
        <div class="col-lg-6">
            <div class="product-image-gallery">
                <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded shadow-sm" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="product-details p-4">
                <h1 class="product-title display-5 fw-bold"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="text-muted lead"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="product-price h2 text-primary fw-bold">$<?php echo number_format($product['price'], 2); ?></p>

                <div class="d-flex align-items-center mb-4">
                    <label for="quantity" class="form-label me-3 fw-bold">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control w-auto">
                </div>
                <button class="btn btn-primary btn-lg add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>

                <div class="mt-4">
                    <a href="index.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left me-2"></i>Back to Shop</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <section id="related-products" class="my-5">
        <h2 class="section-title">You might also like</h2>
        <div class="row g-4">
            <?php while ($related_product = $related_result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="card product-card h-100">
                        <a href="product.php?id=<?php echo $related_product['id']; ?>">
                            <img src="assets/uploads/<?php echo htmlspecialchars($related_product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related_product['name']); ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($related_product['name']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($related_product['category']); ?></p>
                            <p class="h5 text-primary fw-bold">$<?php echo number_format($related_product['price'], 2); ?></p>
                            <button class="btn btn-primary mt-auto add-to-cart" data-product-id="<?php echo $related_product['id']; ?>">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>