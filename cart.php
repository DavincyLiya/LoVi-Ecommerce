<?php require_once __DIR__ . '/header.php'; ?>

<?php
// Handle cart actions via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $redirect = $_POST['redirect'] ?? 'cart.php';

  if ($action === 'add') {
    $id = $_POST['product_id'] ?? '';
    $qty = (int)($_POST['qty'] ?? 1);
    $product = find_product($id);
    if ($product) {
      cart_add($id, $qty);
      header('Location: ' . $redirect);
      exit;
    } else {
      echo '<p class="card" style="color:#b91c1c;">Product not found.</p>';
    }
  }

  if ($action === 'remove') {
    $id = $_POST['product_id'] ?? '';
    cart_remove($id);
    header('Location: cart.php');
    exit;
  }

  if ($action === 'clear') {
    cart_clear();
    header('Location: cart.php');
    exit;
  }
}

$items = cart_items();
?>

<h2>Your Cart</h2>

<?php if (!$items): ?>
  <p class="card">Your cart is empty.</p>
<?php else: ?>
  <div class="card">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Category</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Line Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?php echo e($it['name']); ?></td>
          <td><?php echo ucfirst(e($it['category'])); ?></td>
          <td>₹<?php echo number_format($it['price'], 2); ?></td>
          <td><?php echo (int)$it['qty']; ?></td>
          <td>₹<?php echo number_format($it['line_total'], 2); ?></td>
          <td>
            <form method="post" action="cart.php" style="display:inline;">
              <input type="hidden" name="action" value="remove">
              <input type="hidden" name="product_id" value="<?php echo e($it['id']); ?>">
              <button class="btn" type="submit">Remove</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <p style="text-align:right; font-weight:700; margin-top:10px;">
      Total: ₹<?php echo number_format(cart_total(), 2); ?>
    </p>

    <form method="post" action="cart.php">
      <input type="hidden" name="action" value="clear">
      <button class="btn" type="submit">Clear Cart</button>
    </form>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
