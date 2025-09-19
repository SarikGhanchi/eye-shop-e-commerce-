<?php
include 'includes/db.php';
include 'includes/header.php';

// Fetch featured products using prepared statements
$stmt = $conn->prepare("SELECT * FROM products LIMIT 8");
$stmt->execute();
$featured_products = $stmt->get_result();
?>

<!-- Hero Section -->
<header class="hero-section text-center text-white">
    <div class="container">
        <h1 class="display-4 fw-bold">Find Your Perfect Pair</h1>
        <p class="lead">High-quality eyewear for every style and occasion.</p>
        <a href="#featured-products" class="btn btn-light btn-lg">Shop Now</a>
    </div>
</header>

<div class="container my-5">
    <!-- Categories Section -->
    <section id="categories" class="my-5">
        <h2 class="section-title">Shop by Category</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="category.php?category=men" class="category-card-link">
                    <div class="card category-card">
                        <img src="assets/uploads/m1.jpg" class="card-img-top" alt="Men's Eyewear">
                        <div class="card-body">
                            <h5 class="card-title">Men</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="category.php?category=women" class="category-card-link">
                    <div class="card category-card">
                        <img src="assets/uploads/s1.jpg" class="card-img-top" alt="Women's Eyewear">
                        <div class="card-body">
                            <h5 class="card-title">Women</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="category.php?category=kids" class="category-card-link">
                    <div class="card category-card">
                        <img src="assets/uploads/s3.jpg" class="card-img-top" alt="Kids' Eyewear">
                        <div class="card-body">
                            <h5 class="card-title">Kids</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="category.php?category=sunglasses" class="category-card-link">
                    <div class="card category-card">
                        <img src="assets/uploads/m5.jpg" class="card-img-top" alt="Sunglasses">
                        <div class="card-body">
                            <h5 class="card-title">Sunglasses</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="my-5">
        <h2 class="section-title">Featured Eyewear</h2>
        <div class="row g-4">
            <?php while ($product = $featured_products->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="card product-card h-100">
                        <a href="product.php?id=<?php echo $product['id']; ?>">
                            <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($product['category']); ?></p>
                            <p class="h5 text-primary fw-bold">$<?php echo number_format($product['price'], 2); ?></p>
                            <button class="btn btn-primary mt-auto add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center text-white py-5 my-5">
        <div class="container">
            <h2 class="display-5 fw-bold">Upgrade Your Vision</h2>
            <p class="lead">Explore our collection of premium lenses and frames.</p>
            <a href="category.php?category=men" class="btn btn-outline-light btn-lg">Discover More</a>
        </div>
    </section>
</div>

<?php
include 'includes/footer.php';
?>