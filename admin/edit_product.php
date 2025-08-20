<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

$success = $error = "";

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid product ID.");
}

$product_id = intval($_GET['id']);

// Fetch product
$product_result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($product_result);

if (!$product) {
    die("❌ Product not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = floatval($_POST['price']);

    // Image upload logic (optional)
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp  = $_FILES['image']['tmp_name'];
        $image_path = "../assets/uploads/" . basename($image_name);

        if (move_uploaded_file($image_tmp, $image_path)) {
            $image_sql = ", image = '$image_name'";
        } else {
            $error = "❌ Failed to upload image.";
        }
    } else {
        $image_sql = ""; // No change to image
    }

    if (!$error) {
        $sql = "UPDATE products SET 
                name = '$name', 
                description = '$description', 
                price = '$price'
                $image_sql
                WHERE id = $product_id";

        if (mysqli_query($conn, $sql)) {
            $success = "✅ Product updated successfully!";
            $product_result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
            $product = mysqli_fetch_assoc($product_result);
        } else {
            $error = "❌ Database error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Product</h2>
    <a href="view_products.php" class="btn btn-secondary btn-sm mb-3">← Back to Products</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (Rs)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="../assets/uploads/<?php echo $product['image']; ?>" width="100">
        </div>

        <div class="mb-3">
            <label class="form-label">Upload New Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

</body>
</html>
