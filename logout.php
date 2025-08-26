<?php
session_start();
require_once __DIR__ . '/bootstrap.php';

// If user already requested logout (clicked Yes)
if (isset($_POST['confirm_logout'])) {
    unset($_SESSION['logged_in_user']); // clear only login session
    session_destroy();
    header("Location: index.php");
    exit();
}

// If user clicked cancel
if (isset($_POST['cancel_logout'])) {
    header("Location: categories.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm Logout - LoVi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7fb;
      text-align: center;
      padding: 50px;
    }
    .box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      display: inline-block;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    h2 { margin-bottom: 20px; }
    button, a {
      display: inline-block;
      padding: 12px 20px;
      margin: 8px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
    }
    .yes-btn {
      background: #c62828;
      color: #fff;
    }
    .yes-btn:hover { background: #a31515; }
    .cancel-btn {
      background: #ccc;
      color: #000;
    }
    .cancel-btn:hover { background: #999; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Are you sure you want to log out?</h2>
    <form method="post">
      <button type="submit" name="confirm_logout" class="yes-btn">Yes, Logout</button>
      <button type="submit" name="cancel_logout" class="cancel-btn">Cancel</button>
    </form>
  </div>
</body>
</html>