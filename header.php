<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LoVi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body { font-family: Arial, sans-serif; margin:0; background:#f7f7fb; color:#222; }
  header, footer { background:#0f172a; color:#fff; padding:10px 20px; }
  header h1 { margin:0; display:inline-block; }
  nav { float:right; }
  nav a { color:#fff; text-decoration:none; margin-left:15px; }
  nav a:hover { text-decoration:underline; }
  .pill { background:#2563eb; padding:5px 10px; border-radius:15px; margin-left:10px; }
  main { padding:20px; }
  form { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1); width:300px; }
  input, button { width:100%; padding:10px; margin:5px 0; border:1px solid #ccc; border-radius:5px; }
  button { background:#2563eb; color:#fff; border:none; cursor:pointer; }
  button:hover { background:#1e40af; }
</style>
</head>
<body>
<header>
  <h1>LoVi</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="shop.php?category=electronics">Electronics</a>
    <a href="shop.php?category=fashion">Fashion</a>
    <a href="shop.php?category=beauty">Beauty</a>
    <a href="shop.php?category=furniture">Furniture</a>
    <?php if (is_logged_in()): ?>
        <span class="pill">Hi, <?php echo e($_SESSION['user_email']); ?></span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
  <div style="clear:both;"></div>
</header>
 