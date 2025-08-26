<?php require_once __DIR__ . '/header.php'; ?>

<style>
        /* General reset */
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f5f6f8;
            color: #000000ff;
            line-height: 1.6;
        }

        /* Top header */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border-bottom: 1px solid #ddd;
            padding: 14px 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .top-header .logo {
            font-size: 26px;
            font-weight: bold;
            color: #0056b3;
            text-decoration: none;
        }

        .top-header .search-bar {
            flex: 1;
            margin: 0 40px;
        }

        .top-header .search-bar form {
            display: flex;
        }

        .top-header .search-bar input {
          padding: 12px 25px;
          background: #fffcfcff;
          border: none;
          border-radius: 8px;
          font-size: 18px;
          color: black;
          cursor: pointer;
          transition: 0.3s;
        }

        .top-header .search-bar button {
            padding: 10px 20px;
            background: linear-gradient(45deg, #0056b3, #007bff);
            border: none;
            color: #fff;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .top-header .search-bar button:hover {
            background: linear-gradient(45deg, #003d80, #0056b3);
        }

        .top-header .nav-links a {
            font-size: 16px;
            font-weight: bold;
            color: #0056b3;
            text-decoration: none;
            margin-left: 20px;
        }

        .top-header .nav-links a:hover {
            color: #007bff;
        }

        /* Slider */
        .slider {
            width: 100%;
            height: 280px;
            overflow: hidden;
            position: relative;
            background: #fff;
        }
        .slides {
            display: flex;
            width: 100%;
            height: 100%;
            animation: slide 25s infinite;
        }
        .slides img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            flex-shrink: 0;
        }
        @keyframes slide {
            0%, 15%   { transform: translateX(0%); }
            20%, 35%  { transform: translateX(-100%); }
            40%, 55%  { transform: translateX(-200%); }
            60%, 75%  { transform: translateX(-300%); }
            80%, 95%  { transform: translateX(-400%); }
            100%      { transform: translateX(0%); }
        }
        @media (max-width: 768px) {
            .slider { height: 180px; }
            .slides img { height: 180px; }
        }

        /* Cards */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e2e2;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        /* Responsive grids */
        .grid, .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-top: 16px;
        }

        /* Buttons */
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

<!-- Top header -->
<div class="top-header">
  <a href="index.php" class="logo">LoVi</a>

  <div class="search-bar">
    <form action="shop.php" method="get" style="display:flex; width:100%;">
      <input type="text" name="search" placeholder="Search for products..." required>
      <button type="submit">Search</button>
    </form>
  </div>

  <div class="cart">
    🛒 <a href="cart.php">Cart</a>
  </div>
</div>

<div class="slider">
  <div class="slides">
    <img src="images/lovi-1 (2).png" alt="LoVi">
    <img src="images/electronics (2).png" alt="Electronics">
    <img src="images/fashion.png" alt="Fashion">
    <img src="images/beauty.png" alt="Beauty">
    <img src="images/furniture.png" alt="Furniture">
  </div>
  <a class="prev">&#10094;</a>
  <a class="next">&#10095;</a>
  <div class="dots"></div>
</div>

<!-- Main Content -->
<div style="padding: 20px 40px;">
  <div class="card">
    <h3>Browse by Category</h3>

    <form method="get">
      <div class="field">
        <label for="category" style="margin-right:10px;">Pick a category</label>
        <select id="category" name="category" required>
          <option value="" disabled selected>Select…</option>
          <?php foreach ($CATEGORIES as $c): ?>
            <option value="<?php echo e($c); ?>" 
              <?php if(isset($_GET['category']) && $_GET['category'] == $c) echo 'selected'; ?>>
              <?php echo ucfirst(e($c)); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button class="btn" type="submit">View Products</button>
      </div>
    </form>
  </div>

  <?php
  if (isset($_GET['category'])) {
      $category = $_GET['category'];

      if (isset($PRODUCTS[$category])) {
          echo '<div class="product-grid" style="margin-top:20px;">';
          foreach ($PRODUCTS[$category] as $p) {
              echo '<div class="product-card">';
              echo '<img src="'.$p['image'].'" alt="'.$p['name'].'" style="max-width:100%;height:150px;object-fit:cover;">';
              echo '<h4>'.e($p['name']).'</h4>';
              echo '<p>Price: ₹'.number_format($p['price'], 2).'</p>';
              echo '<a href="product.php?id='.$p['id'].'" class="btn">View</a>';
              echo '</div>';
          }
          echo '</div>';
      } else {
          echo "<p>No products found in this category.</p>";
      }
  }
  ?>
  
  <br>
  <div class="card">
    <h3>Featured Products</h3>
    <div class="grid">
      <?php
        $allProducts = [];
        foreach ($PRODUCTS as $items) {
          foreach ($items as $p) {
            $allProducts[] = $p;
          }
        }
        shuffle($allProducts);
        $randomProducts = array_slice($allProducts, 0, 6);

        foreach ($randomProducts as $p): ?>
          <div class="card">
            <img src="<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>" 
                 style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
            <h4 style="margin:10px 0;"><?php echo e($p['name']); ?></h4>
            <p>₹<?php echo number_format($p['price'], 2); ?></p>
            <a class="btn" href="product.php?id=<?php echo e($p['id']); ?>">View</a>
          </div>
      <?php endforeach; ?>
    </div>
  </div>

  <h3 style="margin-top:24px;">Quick Links</h3>
  <div class="grid">
    <?php 
      $CATEGORY_IMAGES = [
        "electronics" => "images/e-QL.jpeg",
        "fashion"     => "images/F-QL.jpeg",
        "beauty"      => "images/B-QL.jpeg",
        "furniture"   => "images/Fur-QL.jpeg"
      ];
    ?>
    <?php foreach ($CATEGORIES as $c): ?>
      <div class="card" style="
          background: url('<?php echo $CATEGORY_IMAGES[$c] ?? 'static/images/default.jpg'; ?>') center/cover no-repeat;
          color: #fff; 
          height: 200px;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          border-radius: 12px;
          position: relative;
          overflow: hidden;
      ">
        <div style="
          position: absolute;
          inset: 0;
          background: rgba(0,0,0,0.35);
          border-radius: 12px;
        "></div>

        <div style="position: relative; text-align: center; z-index: 1;">
          <h4 style="margin-top:0; font-size:20px; font-weight:600;"><?php echo ucfirst(e($c)); ?></h4>
          <p style="margin: 5px 0;">See items in <?php echo e($c); ?>.</p>
          <a class="btn" href="shop.php?category=<?php echo e($c); ?>" 
             style="background:#007bff; color:#fff; margin-top:10px; padding:8px 16px; border-radius:20px; text-decoration:none; font-weight:500;">
            Open <?php echo ucfirst(e($c)); ?>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
