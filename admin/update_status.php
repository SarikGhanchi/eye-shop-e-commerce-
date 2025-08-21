<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = intval($_POST['order_id']);
    $newStatus = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $newStatus, $orderId);

    if ($stmt->execute()) {
        // Redirect with a success message parameter
        header("Location: http://localhost/eye-shop/admin/view_orders.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error updating status!');</script>";
    }
}
?>

