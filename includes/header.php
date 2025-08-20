<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Eye Shop</title>

  <!-- ✅ Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- (Optional) Bootstrap JS CDN (for dropdowns etc.) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

  <nav class="fixed-top navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Eye Shop</a>
      <div>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
          <li class="nav-item"><a class="nav-link" href="./search.php">Search</a></li>
          <li class="nav-item"><a class="nav-link" href="./cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="./contact.php">Contact</a></li>

          <?php
          if (isset($_SESSION['user_id'])) {
            echo '<li class="nav-item"><a class="nav-link" href="./profile.php">' . $_SESSION['user_name'] . '</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';

          } else { ?>
            <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="./register.php">Register</a></li>

          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <div style="height: 36px;"></div>

  <div class="container mt-4">