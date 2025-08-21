<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

$success = $error = "";

// Fetch categories for dropdown
$category_result = mysqli_query($conn, "SELECT id, name FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);  // ✅ category field

    // Handle image upload
    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_path = "../assets/uploads/" . basename($image_name);

    if (move_uploaded_file($image_tmp, $image_path)) {
        $sql = "INSERT INTO products (name, description, price, image, category)
                VALUES ('$name', '$description', '$price', '$image_name', '$category_id')";

        if (mysqli_query($conn, $sql)) {
            $success = "✅ Product added successfully!";
        } else {
            $error = "❌ Database error: " . mysqli_error($conn);
        }
    } else {
        $error = "❌ Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">👓 Add New Product</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (Rs)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <!-- ✅ Category Dropdown -->
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category"class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php while ($cat = mysqli_fetch_assoc($category_result)) { ?>
                    <option value="<?php echo $cat['name']; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">Back to Dashboard</a>
    </form>
</div>

</body>
</html>
