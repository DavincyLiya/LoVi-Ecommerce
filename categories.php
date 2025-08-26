<?php include 'bootstrap.php'; include 'header.php'; ?>
<h2>Categories</h2>
<ul>
  <?php foreach ($PRODUCTS as $category => $items): ?>
    <li><a href="shop.php?category=<?php echo $category; ?>"><?php echo ucfirst($category); ?></a></li>
  <?php endforeach; ?>
</ul>
</body>
</html>
