<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);

    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        $error = "All fields are required.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered.";
        } else {
            $sql = "INSERT INTO users (name, email, password, phone, address) 
                    VALUES ('$name', '$email', '$password', '$phone', '$address')";
            if (mysqli_query($conn, $sql)) {
                $success = "🎉 Registration successful. <a href='login.php'>Login here</a>";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Eye Zone</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      width: 100%;
    }

    .form-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .register-card {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      max-width: 500px;
      width: 100%;
    }

    .brand-logo {
      font-size: 2rem;
      font-weight: bold;
      color: #764ba2;
    }

    .btn-primary {
      background-color: #764ba2;
      border-color: #764ba2;
    }

    .btn-primary:hover {
      background-color: #5a3b8a;
    }
  </style>
</head>
<body>

<!-- Full-width Navbar
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">👓 Eye Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link active" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav> -->

<!-- Centered Registration Form -->
<div class="form-wrapper">
  <div class="register-card">
    <div class="text-center mb-4">
      <div class="brand-logo">👓 Eye Zone </div>
      <p class="text-muted">Create your account</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST" class="row g-3">
      <div class="col-12">
        <label class="form-label">Full Name</label>
        <input class="form-control" type="text" name="name" required>
      </div>
      <div class="col-12">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="col-12">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <div class="col-12">
        <label class="form-label">Phone</label>
        <input class="form-control" type="text" name="phone" required>
      </div>
      <div class="col-12">
        <label class="form-label">Address</label>
        <textarea class="form-control" name="address" rows="2" required></textarea>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">Register</button>
      </div>
    </form>
    <p class="mt-3 text-center text-muted">Already have an account? <a href="login.php">Login</a></p>
    <?php endif; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
