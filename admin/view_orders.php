<?php
// Include database connection
include '../includes/db.php'; // adjust path if needed

// Fetch orders with user info
$sql = "SELECT o.id, u.name AS customer_name, o.total, o.status 
FROM orders o
JOIN users u ON o.user_id = u.id
ORDER BY o.id ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
         th {
            background-color: #010913ff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            font-weight: bold;
        }
        .status.pending {
            color: orange;
        }
        .status.completed {
            color: green;
        }
        .status.cancelled {
            color: red;
        }
    </style>
</head>
<body>

<h1>Order List</h1>

  <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td>₹<?= htmlspecialchars($row['total']) ?></td>
            <td class="status <?= strtolower($row['status']) ?>">
                <?= htmlspecialchars($row['status']) ?>
            </td>
            <td>
                <button onclick="openModal('<?= $row['id'] ?>','<?= $row['status'] ?>')">Edit</button>
            </td>
        </tr>
    <?php endwhile; ?>
</table>


<!-- ===== Modal Window ===== -->
<div id="statusModal" class="modal" style="display:none;
        position:fixed;top:0;left:0;width:100%;height:100%;
        background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    
    <div style="background:#fff;padding:20px;border-radius:10px;min-width:300px;position:relative;">
        <h3>Change Order Status</h3>
        
        <form id="statusForm" method="POST" action="update_status.php">
            <input type="hidden" name="order_id" id="modalOrderId">
            
            <label for="newStatus">Select Status:</label>
            <select name="new_status" id="modalStatus">
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            
            <br><br>
            <button type="submit">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>


<script>
function openModal(orderId, currentStatus) {
    document.getElementById("modalOrderId").value = orderId;
    document.getElementById("modalStatus").value = currentStatus;
    document.getElementById("statusModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("statusModal").style.display = "none";
}
</script>

<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>

<?php mysqli_close($conn); ?>

</body>
</html>
