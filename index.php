<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>

<style>
  body {
    font-family: 'Poppins', sans-serif;
  }

  /* Section Title */
  .section-title {
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 2rem;
    text-transform: uppercase;
    text-align: center;
    position: relative;
  }
  .section-title::after {
    content: "";
    width: 70px;
    height: 4px;
    background: #0d6efd;
    display: block;
    margin: 0.5rem auto 0;
    border-radius: 2px;
  }

  /* Product Card */
  .product-card {
    transition: all 0.3s ease-in-out;
    border-radius: 1rem;
    overflow: hidden;
  }
  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }
  .product-card img {
    height: 260px;
    object-fit: cover;
  }

  /* Category Cards */
  .category-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: 0.3s;
  }
  .category-card:hover {
    transform: scale(1.03);
  }
  .category-card img {
    height: 250px;
    object-fit: cover;
  }

  /* CTA */
  .cta-banner {
    background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), 
      url('https://static5.lenskart.com/media/uploads/web_banner_corpcore_24062025_rat.png');
    background-size: cover;
    background-position: center;
    border-radius: 1rem;
    color: #fff;
    padding: 5rem 2rem;
    text-align: center;
  }
  .cta-banner h2 {
    font-size: 2.5rem;
    font-weight: 700;
  }

  /* Animation on scroll */
  [data-animate] {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.7s ease-in-out;
  }
  [data-animate].visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<!-- MAIN CONTENT -->
<div class="container my-5">

  <!-- ✅ HERO CAROUSEL -->
  <div id="heroCarousel" class="carousel slide mb-5 rounded shadow" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner rounded">
      <div class="carousel-item active">
        <img src="https://static1.lenskart.com/media/desktop/img/16-sep-24/r1.jpeg" class="d-block w-100 img-fluid" alt="Premium Eyewear">
      </div>
      <div class="carousel-item">
        <img src="https://static1.lenskart.com/media/desktop/img/Dec22/1-Dec/Homepage-Banner-web.gif" class="d-block w-100 img-fluid" alt="Stylish Frames">
      </div>
      <div class="carousel-item">
        <img src="https://static1.lenskart.com/media/desktop/img/Jan23/sunglasses/Sun-Banner-web.gif" class="d-block w-100 img-fluid" alt="Kids Eyewear">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- ✅ CATEGORIES -->
  <h2 class="section-title text-primary mb-4">Shop by Category</h2>
<div class="row g-4 mb-5">

  <!-- Men -->
  <div class="col-md-3" data-animate>
    <a href="category.php?category=men" class="text-decoration-none text-dark">
      <div class="card category-card shadow-sm h-100">
        <img src="https://funkytradition.com/cdn/shop/files/0_Hb981363180f04fd28b49deb30bb484abD_09b5ba2a-2432-457e-8e06-ad6be187903d.jpg?v=1723556521"
             class="card-img-top category-img" alt="Men Eyewear">
        <div class="card-body text-center">
          <h5 class="fw-bold">Men</h5>
        </div>
      </div>
    </a>
  </div>

  <!-- Women -->
  <div class="col-md-3" data-animate>
    <a href="category.php?category=women" class="text-decoration-none text-dark">
      <div class="card category-card shadow-sm h-100">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRRQZ7yy4ZwNCOmCxTZ2JUQDXpLJyvkn1gZw&s"
             class="card-img-top category-img" alt="Women Eyewear">
        <div class="card-body text-center">
          <h5 class="fw-bold">Women</h5>
        </div>
      </div>
    </a>
  </div>

  <!-- Kids -->
  <div class="col-md-3" data-animate>
    <a href="category.php?category=kids" class="text-decoration-none text-dark">
      <div class="card category-card shadow-sm h-100">
        <img src="https://static5.lenskart.com/media/catalog/product/pro/1/thumbnail/480x480/9df78eab33525d08d6e5fb8d27136e95//model/h/i/kids-glasses:-blue-full-rim-hexagonal-kids--5-8-yrs--lenskart-junior-owlers-lkj-e10073-c1_27_july_kids_shoot303668_146670_03aug23.jpg"
             class="card-img-top category-img" alt="Kids Eyewear">
        <div class="card-body text-center">
          <h5 class="fw-bold">Kids</h5>
        </div>
      </div>
    </a>
  </div>

  <!-- Sunglasses -->
  <div class="col-md-3" data-animate>
    <a href="category.php?category=sunglasses" class="text-decoration-none text-dark">
      <div class="card category-card shadow-sm h-100">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/025/935/223/small_2x/reflection-in-the-sunglasses-shows-sea-beach-summer-concept-generative-ai-photo.jpg"
             class="card-img-top category-img" alt="Sunglasses">
        <div class="card-body text-center">
          <h5 class="fw-bold">Sunglasses</h5>
        </div>
      </div>
    </a>
  </div>

</div>

<style>
  .category-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: transform .3s ease, box-shadow .3s ease;
    cursor: pointer;
  }
  .category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
  .category-img {
    height: 220px;
    object-fit: cover;
  }
</style>

  <!-- ✅ FEATURED PRODUCTS -->
  <h2 class="section-title text-primary">✨ Featured Eyewear ✨</h2>
  <div class="row">
    <?php
    $query = "SELECT * FROM products LIMIT 6";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
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
      echo '<div class="col-12"><p class="text-muted text-center">No eyewear products available.</p></div>';
    }
    ?>
  </div>

  <!-- ✅ CTA -->
  <div class="cta-banner my-5 shadow">
    <h2>Transform Your Look with Stylish Eyewear</h2>
    <p class="mb-4">Premium spectacles & sunglasses designed for comfort, clarity & style.</p>
    <a href="shop.php" class="btn btn-light btn-lg fw-semibold px-4">Explore Collection</a>
  </div>

  <!-- ✅ NEWSLETTER -->
  <div class="bg-light rounded shadow p-5 text-center">
    <h3 class="fw-bold mb-3">Stay in Style 👓</h3>
    <p class="text-muted mb-4">Subscribe to get the latest eyewear trends & exclusive offers.</p>
    <form class="row g-2 justify-content-center">
      <div class="col-md-6 col-lg-4">
        <input type="email" class="form-control form-control-lg" placeholder="Enter your email">
      </div>
      <div class="col-auto">
        <button class="btn btn-primary btn-lg">Subscribe</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Scroll animations
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
