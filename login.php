<?php
include 'includes/db.php';
include 'includes/header.php';

session_start(); // Make sure this is at the top if not in header.php

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                // Store session values
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role']; // 👈 Store role here

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Eye Zone</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .login-wrapper {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background: white;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
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

<!-- Login Form -->
<div class="login-wrapper">
  <div class="login-card">
    <div class="text-center mb-4">
      <div class="brand-logo">👓 Eye Zone </div>
      <p class="text-muted">Please log in to continue</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
      <div class="col-12">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="col-12">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </div>
    </form>

    <p class="mt-3 text-center text-muted">New member? <a href="register.php">Create an Account</a></p>
  </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
