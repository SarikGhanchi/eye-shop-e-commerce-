<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }
    header("Location: cart.php");
    exit();
}

// Remove from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
  <div class="alert alert-info">Your cart is empty. <a href="index.php">Shop Now</a></div>
<?php else: ?>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Name</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $pid => $qty):
          // ✅ Fetch product from DB
          $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $pid");
          $product = mysqli_fetch_assoc($res);

          if ($product):
              $subtotal = $product['price'] * $qty;
              $total += $subtotal;
    ?>
      <tr>
        <td><?php echo htmlspecialchars($product['name']); ?></td>
        <td>₹<?php echo number_format($product['price'], 2); ?></td>
        <td><?php echo $qty; ?></td>
        <td>₹<?php echo number_format($subtotal, 2); ?></td>
        <td><a href="cart.php?action=remove&id=<?php echo $pid; ?>" class="btn btn-sm btn-danger">Remove</a></td>
      </tr>
    <?php
          endif;
      endforeach;
    ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3"><strong>Total:</strong></td>
        <td colspan="2"><strong>₹<?php echo number_format($total, 2); ?></strong></td>
      </tr>
    </tfoot>
  </table>
  <!-- <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a> -->
  <div class="d-flex justify-content-between mt-3">
  <a href="index.php" class="btn btn-outline-secondary">
    🛒 Add More Items
  </a>
  <a href="checkout.php" class="btn btn-success">
    ✅ Proceed to Checkout
  </a>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
