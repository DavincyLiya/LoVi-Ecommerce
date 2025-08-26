<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/connection1.php';

$success = "";
$error   = "";

// If already logged in → redirect
if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $isValid = false;

        // ✅ 1. Check database users
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $isValid = true;
        }

        // ✅ 2. Check hardcoded demo users
        global $USERS;
        if (!$isValid && isset($USERS[$username]) && $USERS[$username] === $password) {
            $_SESSION['user_email'] = $username;
            $isValid = true;
        }

        // ✅ 3. Check registered user stored in session
        if (!$isValid && isset($_SESSION['registered_user'])) {
            $registered = $_SESSION['registered_user'];
            if ($username === $registered['username'] && password_verify($password, $registered['password'])) {
                $_SESSION['user_email'] = $username;
                $isValid = true;
            }
        }

        if ($isValid) {
            $success = "Login successful! Redirecting...";
            header("refresh:2;url=index.php");
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login - LoVi</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(135deg, #f1f8ff, #e3f2fd);
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 40px 15px;
    }
    .auth-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 420px;
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #0056b3;
      font-size: 28px;
    }
    .input-group { margin-bottom: 18px; }
    label {
      font-size: 15px;
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      color: #333;
    }
    input {
      width: 100%;
      padding: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      transition: border 0.3s;
    }
    input:focus { border-color: #0056b3; outline: none; }
    .btn {
      width: 100%;
      padding: 14px;
      background: #0056b3;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 18px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }
    .btn:hover { background: #003d80; }
    .error {
      color: #c62828;
      background: #ffebee;
      border: 1px solid #ffcdd2;
      padding: 10px 12px;
      border-radius: 6px;
      margin-bottom: 16px;
      text-align: left;
      font-weight: 600;
    }
    .success {
      color: #2e7d32;
      background: #e8f5e9;
      border: 1px solid #c8e6c9;
      padding: 10px 12px;
      border-radius: 6px;
      margin-bottom: 16px;
      text-align: left;
      font-weight: 600;
    }
    .switch {
      text-align: center;
      margin-top: 20px;
      font-size: 15px;
    }
    .switch a { color: #0056b3; text-decoration: none; font-weight: 600; }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Login</h2>
    <?php if ($error): ?><div class="error"><?php echo e($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo e($success); ?></div><?php endif; ?>

    <form method="POST">
      <div class="input-group">
        <label>Username / Email</label>
        <input type="text" name="username" required>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <div class="switch">
      Don’t have an account? <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>
