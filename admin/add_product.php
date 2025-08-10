<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include '../includes/db.php';
include '../includes/auth.php'; // make sure only admin can access

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);

    // Handle image upload
    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_path = "../assets/uploads/" . $image_name;

    if (move_uploaded_file($image_tmp, $image_path)) {
        $sql = "INSERT INTO products (name, description, price, category_id, image)
                VALUES ('$name', '$description', '$price', '$category_id', '$image_name')";

        if (mysqli_query($conn, $sql)) {
            $success = "✅ Product added successfully.";
        } else {
            $error = "❌ Database error: " . mysqli_error($conn);
        }
    } else {
        $error = "❌ Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Add New Product 👓</h2>

<?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php elseif ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Product Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Price (Rs):</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Category ID:</label><br>
    <input type="number" name="category_id" required><br><br>

    <label>Upload Image:</label><br>
    <input type="file" name="image" accept="image/*" required><br><br>

    <input type="submit" value="Add Product">
</form>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>
