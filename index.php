<?php
// index.php
// include 'includes/auth.php';
include 'includes/db.php';
include 'includes/header.php';
?>

  <div class="container mt-4"> 
    
    <!-- Carousel -->
    <div id="eyewearCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://m.media-amazon.com/images/I/41f7R+q8zXL._SX679_.jpg" class="d-block w-100" alt="Eyewear Banner 1">
        </div>
        <div class="carousel-item active">
          <img src="https://m.media-amazon.com/images/I/5165TS+iXVL._SX679_.jpg" class="d-block w-100" alt="Eyewear Banner 2">
        </div>
       <div class="carousel-item active">
        <img src="https://m.media-amazon.com/images/I/5165TS+iXVL._SX679_.jpg" class="d-block w-100" alt="Eyewear Banner 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#eyewearCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#eyewearCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
  <div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Product Cards -->
<div class="row">
  <?php
  $query = "SELECT * FROM products";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
  ?>
    <div class="col-md-4 mb-4">
      <div class="card product-card h-100 border-0 shadow-sm position-relative">
        
        <!-- Badge (if needed) -->
        <?php if ($row['is_new']) { ?>
          <span class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
        <?php } ?>

        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">

        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>

          <!-- Ratings -->
          <div class="mb-2">
            <span class="text-warning">★ ★ ★ ★ ☆</span>
            <small class="text-muted">(120)</small>
          </div>

          <p class="card-text text-muted small"><?php echo htmlspecialchars($row['description']); ?></p>

          <!-- Price Section -->
          <div class="mb-3">
            <span class="text-success fw-bold h5">$<?php echo number_format($row['price'], 2); ?></span>
            <?php if (!empty($row['old_price']) && $row['old_price'] > $row['price']) { ?>
              <span class="text-muted text-decoration-line-through ms-2">$<?php echo number_format($row['old_price'], 2); ?></span>
              <span class="badge bg-danger ms-2"><?php echo round((($row['old_price'] - $row['price']) / $row['old_price']) * 100); ?>% OFF</span>
            <?php } ?>
          </div>

          <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-outline-primary mt-auto w-100">🛒 Add to Cart</a>
        </div>
      </div>
    </div>
  <?php
    }
  } else {
    echo '<div class="col-12"><p class="text-muted text-center">No products available.</p></div>';
  }
  ?>
</div>


<?php
include 'includes/footer.php';
?>