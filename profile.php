<?php
// Include database connection
include 'includes/db.php';
include 'includes/header.php';

session_start();
$user_id = $_SESSION['user_id'];

// Prepare statement
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();

// Fetch result
$result = $query->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0px 4px 20px rgba(0,0,0,0.08);
    }
    .card-header {
     background-color: #764ba2;
      border-color: rgba(118, 75, 162, 1);
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
        color: white;
    }
    .card-header h3 {
      margin: 0;
      font-weight: 600;
    }
    .list-group-item {
      border: none;
      padding: 14px 20px;
      font-size: 16px;
    }
    .list-group-item strong {
      color: #343a40;
    }
    .modal-content {
      border-radius: 12px;
    }
    .btn-primary, .btn-success {
      border-radius: 8px;
      padding: 8px 18px;
    }
    .sarik {
      background-color: #764ba2;
      border-color: rgba(118, 75, 162, 1);
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header text-center sarik">
          <h3>👤 My Profile</h3>
        </div>
        <div class="card-body">
          <?php if ($user): ?>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item d-flex justify-content-between">
                <strong>Name:</strong> <span><?php echo htmlspecialchars($user['name']); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <strong>Email:</strong> <span><?php echo htmlspecialchars($user['email']); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <strong>Phone:</strong> <span><?php echo htmlspecialchars($user['phone']); ?></span>
              </li>
            </ul>
            <div class="text-center">
              <button class="btn btn-primary sarik" data-bs-toggle="modal" data-bs-target="#editModal">✏️ Edit Profile</button>
            </div>
          <?php else: ?>
            <p class="text-center text-danger">⚠️ Profile not found.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="editprofile.php" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Profile</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">💾 Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
