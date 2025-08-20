<?php
include 'includes/db.php';
include 'includes/header.php';

// Get category from query param
$category = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : null;

// Whitelist of allowed categories
$valid_categories = ['men', 'women', 'kids', 'sunglasses'];

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
    background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)),
      url('https://static1.lenskart.com/media/desktop/img/Aug23/23rdAug/1920x520-men.jpg');
    background-size: cover;
    background-position: center;
    padding: 5rem 2rem;
    text-align: center;
    color: #fff;
    border-radius: 1rem;
    margin-bottom: 3rem;
  }
  .category-banner h1 {
    font-size: 3rem;
    font-weight: 700;
  }

  /* Product Card (same as index but enhanced slightly) */
  .product-card {
    transition: all 0.3s ease-in-out;
    border-radius: 1rem;
    overflow: hidden;
  }
  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0,0,0,.15);
  }
  .product-card img {
    height: 250px;
    object-fit: cover;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }
  .empty-state img {
    width: 220px;
    margin-bottom: 1.5rem;
  }
  .empty-state h3 {
    font-weight: 600;
    margin-bottom: 1rem;
  }
</style>

<div class="container my-5">

  <?php if (isset($error_message)) { ?>
      <!-- Invalid Category -->
      <div class="empty-state">
        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486803.png" alt="No Category">
        <h3><?php echo $error_message; ?></h3>
        <p class="text-muted">The eyewear category you are looking for doesn’t exist.</p>
        <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
      </div>

  <?php } else { ?>

      <!-- ✅ Category Banner -->
      <div class="category-banner shadow">
        <h1 class="mb-3 text-capitalize"><?php echo htmlspecialchars($category); ?> Eyewear</h1>
        <p class="lead">Explore our latest collection of premium <?php echo htmlspecialchars($category); ?> eyewear styles.</p>
      </div>

      <!-- ✅ Product Grid -->
      <div class="row">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-md-6 col-lg-4 mb-4" data-animate>
              <div class="card product-card h-100 shadow-sm position-relative">
                <?php if (isset($row['is_new']) && $row['is_new']) { ?>
                  <span class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
                <?php } ?>
                <img src="assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title fw-semibold"><?php echo htmlspecialchars($row['name']); ?></h5>
                  <div class="mb-2"><span class="text-warning">★ ★ ★ ★ ☆</span> <small class="text-muted">(120 reviews)</small></div>
                  <p class="card-text text-muted small mb-3"><?php echo htmlspecialchars($row['description']); ?></p>
                  <div class="mb-3">
                    <span class="text-success fw-bold h5">$<?php echo number_format($row['price'], 2); ?></span>
                    <?php if (!empty($row['old_price']) && $row['old_price'] > $row['price']) { ?>
                      <span class="text-muted text-decoration-line-through ms-2">$<?php echo number_format($row['old_price'], 2); ?></span>
                      <span class="badge bg-danger ms-2"><?php echo round((($row['old_price'] - $row['price']) / $row['old_price']) * 100); ?>% OFF</span>
                    <?php } ?>
                  </div>
                  <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary mt-auto w-100">🛒 Add to Cart</a>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          // ✅ Empty Products State
          echo '
            <div class="col-12">
              <div class="empty-state">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076500.png" alt="No Products">
                <h3>No Products Found</h3>
                <p class="text-muted">We couldn’t find any eyewear in this category.</p>
                <a href="index.php" class="btn btn-outline-primary mt-3">Back to Home</a>
              </div>
            </div>
          ';
        }
        ?>
      </div>

  <?php } ?>
</div>

<script>
  // Simple scroll animation
  const elements = document.querySelectorAll('[data-animate]');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  elements.forEach(el => observer.observe(el));
</script>

<?php include 'includes/footer.php'; ?>
