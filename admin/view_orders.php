<?php
include 'partials/header.php';
include '../includes/db.php';

$sql = "SELECT o.id, u.name AS customer_name, o.total, o.status, o.created_at FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="section-title-admin">All Orders</h1>

<div class="card card-admin shadow mb-4">
    <div class="card-header-admin py-3">
        <h6 class="m-0 fw-bold">Order List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-admin" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td>$<?php echo number_format($row['total'], 2); ?></td>
                            <td><span class="badge bg-<?php echo strtolower($row['status']) == 'delivered' ? 'success' : (strtolower($row['status']) == 'pending' ? 'warning' : 'info'); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td><?php echo date("d M, Y", strtotime($row['created_at'])); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal" data-order-id="<?php echo $row['id']; ?>" data-order-status="<?php echo $row['status']; ?>">
                                    <i class="bi bi-pencil-square"></i> Update Status
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="update_status.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="modalOrderId">
                    <div class="mb-3">
                        <label for="modalStatus" class="form-label">Status</label>
                        <select name="new_status" id="modalStatus" class="form-select form-control-admin">
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const statusModal = document.getElementById('statusModal');
    statusModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-order-id');
        const orderStatus = button.getAttribute('data-order-status');
        
        const modalOrderId = statusModal.querySelector('#modalOrderId');
        const modalStatus = statusModal.querySelector('#modalStatus');

        modalOrderId.value = orderId;
        modalStatus.value = orderStatus;
    });
</script>

<?php include 'partials/footer.php'; ?>