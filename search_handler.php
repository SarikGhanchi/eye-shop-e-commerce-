<?php
include 'includes/db.php';

if (isset($_POST['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT * FROM products WHERE name LIKE '%$keyword%' OR description LIKE '%$keyword%' LIMIT 10";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col">
                <div class="card h-100">
                    <img src="' . $row['image'] . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                        <p class="card-text">' . substr(htmlspecialchars($row['description']), 0, 60) . '...</p>
                        <p><strong>₹' . $row['price'] . '</strong></p>
                        <a href="product.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">View</a>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning">No products found for "<strong>' . htmlspecialchars($keyword) . '</strong>"</div>';
    }
}
?>
