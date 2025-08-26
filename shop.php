<?php require_once __DIR__ . '/header.php'; ?>

<?php
global $CATEGORIES, $PRODUCTS;

$items = [];
$title = "";

// ✅ Case 1: Category browsing
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = strtolower(trim($_GET['category']));
    if (in_array($category, $CATEGORIES, true)) {
        $items = $PRODUCTS[$category] ?? [];
        $title = ucfirst($category) . " Products";
    } else {
        echo '<main><p class="card">Invalid category. Please choose one from the homepage.</p></main>';
        require_once __DIR__ . '/footer.php';
        exit;
    }
}

// ✅ Case 2: Searching
elseif (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = strtolower(trim($_GET['search']));
    foreach ($PRODUCTS as $cat => $products) {
        foreach ($products as $p) {
            if (strpos(strtolower($p['name']), $searchTerm) !== false) {
                $items[] = $p;
            }
        }
    }
    $title = "Search Results for '" . htmlspecialchars($_GET['search']) . "'";
}

// ✅ Case 3: Nothing given
else {
    echo '<main><h2>Shop Page</h2><p>Please select a category or use the search bar.</p></main>';
    require_once __DIR__ . '/footer.php';
    exit;
}
?>

<main>
  <h2><?php echo e($title); ?></h2>

  <!-- ✅ Popup always present -->
  <div id="popup" style="
      background: #4CAF50;
      color: #fff;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      display: none;
      text-align: center;
      font-weight: bold;
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
  ">
    ✅ Product added to cart!
  </div>

  <?php if (empty($items)): ?>
    <p class="card">No products found.</p>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach ($items as $p): ?>
        <div class="product-card">
          <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>">
          <h3><?php echo e($p['name']); ?></h3>
          <p class="price">₹<?php echo number_format($p['price'], 2); ?></p>

          <form method="post" action="cart.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?php echo e($p['id']); ?>">
            <input type="hidden" name="redirect" value="<?php echo e($_SERVER['REQUEST_URI']); ?>">

            <div class="cart-row">
              <label for="qty_<?php echo e($p['id']); ?>">Qty</label>
              <input type="number" id="qty_<?php echo e($p['id']); ?>" name="qty" value="1" min="1" required class="product-qty">
              <button class="btn primary add-to-cart-btn" type="submit">Add to Cart</button>
            </div>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<style>
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 per row */
    gap: 15px;
    padding: 15px;
}
.product-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.product-card img {
    max-width: 90%;
    height: auto;
    margin-bottom: 8px;
}
.price {
    font-weight: bold;
    color: #0e6be4ff;
    margin: 8px 0;
    font-size: 0.9rem;
}
.btn.primary {
    background: #0e6be4ff;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 5px;
    font-size: 0.85rem;
}
.btn.primary:hover { background: #0056b3; }
.cart-row {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 8px;
}
.cart-row label {
    margin-right: 3px;
    font-weight: 500;
    font-size: 0.85rem;
}
.product-qty {
    width: 50px;
    padding: 4px;
    text-align: center;
    font-size: 0.85rem;
}
</style>

<!-- ✅ JavaScript for popup -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const popup = document.getElementById("popup");
  const buttons = document.querySelectorAll(".add-to-cart-btn");

  buttons.forEach(btn => {
    btn.addEventListener("click", function() {
      popup.style.display = "block";
      setTimeout(() => popup.style.display = "none", 3000);
    });
  });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>