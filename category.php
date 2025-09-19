<?php
include 'includes/db.php';
include 'includes/header.php';

// Get category from query param
$category = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : null;

// Whitelist of allowed categories
$valid_categories = ['men', 'women', 'kids', 'sunglasses'];

// Default image for category banner
$banner_image = 'https://images.unsplash.com/photo-1574180363478-2b3a7a4d7c2c?q=80&w=1887&auto=format&fit=crop'; // Fallback image

// Assign banner image based on category
switch ($category) {
    case 'men':
        $banner_image = 'https://static1.lenskart.com/media/desktop/img/Aug23/23rdAug/1920x520-men.jpg';
        break;
    case 'women':
        $banner_image = 'https://images.unsplash.com/photo-1511485977113-f34c92461ad9?q=80&w=1935&auto=format&fit=crop';
        break;
    case 'kids':
        $banner_image = 'https://static5.lenskart.com/media/desktop/img/Jan23/sunglasses/Sun-Banner-web.gif';
        break;
    case 'sunglasses':
        $banner_image = 'https://static.vecteezy.com/system/resources/thumbnails/025/935/223/small_2x/reflection-in-the-sunglasses-shows-sea-beach-summer-concept-generative-ai-photo.jpg';
        break;
}

if (!$category || !in_array($category, $valid_categories)) {
    $error_message = "Oops! Category not found.";
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<style>
    .category-banner {
        background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url('<?php echo $banner_image; ?>');
        background-size: cover;
        background-position: center;
        padding: 5rem 2rem;
        text-align: center;
        color: #fff;
        border-radius: 1rem;
        margin-bottom: 3rem;
    }
    .category-banner h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }
</style>

<div class="container my-5">

    <?php if (isset($error_message)) { ?>
        <div class="empty-state alert alert-warning text-center py-5">
            <i class="bi bi-exclamation-triangle display-4 text-warning mb-3"></i>
            <h3 class="mt-3"><?php echo $error_message; ?></h3>
            <p class="text-muted">The eyewear category you are looking for doesn’t exist or is invalid.</p>
            <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
        </div>

    <?php } else { ?>

        <div class="category-banner shadow">
            <h1 class="mb-3 text-capitalize"><?php echo htmlspecialchars($category); ?> Eyewear</h1>
            <p class="lead">Explore our latest collection of premium <?php echo htmlspecialchars($category); ?> eyewear styles.</p>
        </div>

        <div class="row g-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card product-card h-100">
                            <a href="product.php?id=<?php echo $row['id']; ?>">
                                <img src="assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="h5 text-primary fw-bold">$<?php echo number_format($row['price'], 2); ?></p>
                                <button class="btn btn-primary mt-auto add-to-cart" data-product-id="<?php echo $row['id']; ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
            ?>
                <div class="col-12">
                    <div class="empty-state alert alert-info text-center py-5">
                        <i class="bi bi-eyeglasses display-4 text-info mb-3"></i>
                        <h3 class="mt-3">No Products Found</h3>
                        <p class="text-muted">We couldn’t find any eyewear in this category at the moment.</p>
                        <a href="index.php" class="btn btn-outline-primary mt-3">Explore Other Categories</a>
                    </div>
                </div>
            <?php
            } 
            ?>
        </div>

    <?php } ?>
</div>

<?php include 'includes/footer.php'; ?>