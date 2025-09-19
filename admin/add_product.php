<?php
include 'partials/header.php';
include '../includes/db.php';

$success = $error = "";

// Fetch categories for dropdown using prepared statement
$stmt_cat = $conn->prepare("SELECT id, name FROM categories");
$stmt_cat->execute();
$category_result = $stmt_cat->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = intval($_POST['category']); // Assuming category is ID now

    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_path = "../assets/uploads/" . basename($image_name);

    if (move_uploaded_file($image_tmp, $image_path)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $description, $price, $image_name, $category_id); // Assuming category_id is int

        if ($stmt->execute()) {
            $success = "Product added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Failed to upload image.";
    }
}
?>

<h1 class="section-title-admin">Add New Product</h1>

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
                <input type="text" class="form-control form-control-admin" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control form-control-admin" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control form-control-admin" id="price" name="price" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select form-control-admin" id="category" name="category" required>
                        <option value="">-- Select Category --</option>
                        <?php while ($cat = $category_result->fetch_assoc()) { ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control form-control-admin" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-admin-primary">Add Product</button>
        </form>
    </div>
</div>

<?php include 'partials/footer.php'; ?>