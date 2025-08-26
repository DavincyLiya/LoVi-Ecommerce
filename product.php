<?php
require_once __DIR__ . '/bootstrap.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product = find_product($_GET['id']);

if (!$product) {
    echo "<h2>Product not found</h2>";
    exit;
}
?>

<?php require_once __DIR__ . '/header.php'; ?>

<style>
.product-details {
  display: flex;
  gap: 30px;
  padding: 40px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.product-details img {
  width: 300px;
  height: 300px;
  object-fit: cover;
  border-radius: 12px;
  border: 1px solid #eee;
}
.product-info {
  flex: 1;
}
.product-info h2 {
  margin: 0 0 15px;
}
.product-info p {
  font-size: 16px;
  margin: 8px 0;
}
.price {
  font-size: 22px;
  color: #0056b3;
  font-weight: bold;
  margin: 15px 0;
}
.btn {
  display: inline-block;
  padding: 10px 20px;
  background: linear-gradient(45deg, #0056b3, #007bff);
  color: #fff;
  text-decoration: none;
  border-radius: 25px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn:hover {
  background: linear-gradient(45deg, #003d80, #0056b3);
  transform: scale(1.05);
}


</style>

<div class="product-details">
  <img src="<?php echo e($product['image']); ?>" alt="<?php echo e($product['name']); ?>">
  <div class="product-info">
    <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
  <div id="popup" style="
      background: #4CAF50;
      color: #fff;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      display: none;
      text-align: center;
      font-weight: bold;
  ">
    ✅ Product added to cart!
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let popup = document.getElementById("popup");
      popup.style.display = "block";
      setTimeout(() => popup.style.display = "none", 3000); // hide after 3 sec
    });
  </script>
<?php endif; ?>

    <h2><?php echo e($product['name']); ?></h2>
    <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
    <form method="post" action="cart_add.php">
      <input type="hidden" name="id" value="<?php echo e($product['id']); ?>">
      <label>Quantity:</label>
      <input type="number" name="qty" value="1" min="1" style="width:60px; margin-left:10px;">
      <br><br>
      <button type="submit" class="btn">Add to Cart</button>
      <a href="index.php" class="btn" >Back to Home</a>
    </form>
    
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
