<?php
include 'partials/header.php';
include '../includes/db.php';

// Fetch all users
$stmt = $conn->prepare("SELECT id, name, email, role, created_at FROM users ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="section-title-admin">All Users</h1>

<div class="card card-admin shadow mb-4">
    <div class="card-header-admin py-3">
        <h6 class="m-0 fw-bold">User List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-admin" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">User</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date("d M, Y", strtotime($user['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>