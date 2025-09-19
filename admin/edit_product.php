<?php
include 'partials/header.php';
include '../includes/db.php';

$success = $error = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);

    $image_sql = "";
    $image_name = "";
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp  = $_FILES['image']['tmp_name'];
        $image_path = "../assets/uploads/" . basename($image_name);

        if (move_uploaded_file($image_tmp, $image_path)) {
            $image_sql = ", image = ?";
        } else {
            $error = "Failed to upload new image.";
        }
    }

    if (!$error) {
        if ($image_sql) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? $image_sql WHERE id = ?");
            $stmt->bind_param("ssdssi", $name, $description, $price, $category_id, $image_name, $product_id);
        } else {
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $name, $description, $price, $category_id, $product_id);
        }

        if ($stmt->execute()) {
            $success = "Product updated successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch product details
$stmt_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$product = $stmt_product->get_result()->fetch_assoc();
$stmt_product->close();

if (!$product) {
    die("Product not found.");
}

// Fetch categories for dropdown
$stmt_cat = $conn->prepare("SELECT id, name FROM categories");
$stmt_cat->execute();
$category_result = $stmt_cat->get_result();
?>

<h1 class="section-title-admin">Edit Product</h1>

<div class="card card-admin shadow mb-4">
    <div class="card-header-admin py-3">
        <h6 class="m-0 fw-bold">Product Details</h6>
    </div>
    <div class="card-body">
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control form-control-admin" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control form-control-admin" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control form-control-admin" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select form-control-admin" id="category_id" name="category_id" required>
                        <option value="">-- Select Category --</option>
                        <?php while ($cat = $category_result->fetch_assoc()) { ?>
                            <option value="<?php echo $cat['id']; ?>" <?php if ($product['category_id'] == $cat['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Current Image</label><br>
                    <img src="../assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" width="100" class="rounded">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Upload New Image (optional)</label>
                    <input type="file" class="form-control form-control-admin" id="image" name="image" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn btn-admin-primary">Update Product</button>
            <a href="view_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'partials/footer.php'; ?>