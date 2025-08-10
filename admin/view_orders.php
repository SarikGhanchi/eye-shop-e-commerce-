
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>


<?php
include '../includes/db.php';
include '../includes/auth.php'; // admin session check
include '../includes/header.php';

$orders = mysqli_query($conn, "
    SELECT o.*, u.name AS user_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
?>

<h2>🧾 All Orders</h2>

<?php if (mysqli_num_rows($orders) == 0): ?>
    <p>No orders placed yet.</p>
<?php else: ?>
    <?php while ($order = mysqli_fetch_assoc($orders)): ?>
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
            <h3>Order ID: <?php echo $order['id']; ?></h3>
            <p><strong>User:</strong> <?php echo $order['user_name']; ?> (<?php echo $order['email']; ?>)</p>
            <p><strong>Total:</strong> Rs. <?php echo $order['total']; ?></p>
            <p><strong>Placed on:</strong> <?php echo $order['created_at']; ?></p>

            <h4>Items:</h4>
            <ul>
                <?php
                $order_id = $order['id'];
                $items = mysqli_query($conn, "
                    SELECT oi.*, p.name
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = $order_id
                ");
                while ($item = mysqli_fetch_assoc($items)):
                ?>
                    <li>
                        <?php echo $item['name']; ?> –
                        Qty: <?php echo $item['quantity']; ?> –
                        Price: Rs. <?php echo $item['price']; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

<a href="dashboard.php">← Back to Dashboard</a>

<?php include '../includes/footer.php'; ?>
