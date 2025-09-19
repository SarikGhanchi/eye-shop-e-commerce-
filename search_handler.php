<?php
include 'includes/db.php';

if (isset($_POST['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT * FROM products WHERE name LIKE '%$keyword%' OR description LIKE '%$keyword%' LIMIT 10";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col">
                <div class="card product-card h-100 shadow-sm">
                    <img src="assets/uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">' . htmlspecialchars($row['name']) . '</h5>
                        <p class="card-text text-muted small mb-3">' . substr(htmlspecialchars($row['description']), 0, 60) . '...</p>
                        <div class="mt-auto">
                          <p class="card-text text-success fw-bold h5">
 . number_format($row['price'], 2) . '</p>
                          <a href="product.php?id=' . $row['id'] . '" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-info text-center"><i class="bi bi-info-circle-fill"></i> No products found for "<strong>' . htmlspecialchars($keyword) . '</strong>".</div>';
    }
}
?>
