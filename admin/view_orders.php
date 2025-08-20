<?php
// Include database connection
include '../includes/db.php'; // adjust path if needed

// Fetch orders with user info
$sql = "SELECT o.id, u.name AS customer_name, o.total_amount, o.order_date, o.status 
FROM orders o
JOIN users u ON o.user_id = u.id
ORDER BY o.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
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
            background-color: #007BFF;
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

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
               <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td>₹<?= htmlspecialchars($row['total_amount']) ?></td>
            <td><?= htmlspecialchars($row['order_date']) ?></td>
            <td class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></td>
            <td><a href="order_details.php?id=<?= $row['id'] ?>">View</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>

<?php mysqli_close($conn); ?>

</body>
</html>
