<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/connection1.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');

    if ($username && $email && $password && $confirm && $address && $phone) {
        if ($password !== $confirm) {
            $error = "Passwords do not match.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
            $error = "Phone number must be 10 digits.";
        } else {
            // Check if username/email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Username or Email already taken.";
            } else {
                // Hash password and insert
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, address, phone) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $username, $email, $hash, $address, $phone);

                if ($stmt->execute()) {
                    $success = "Registration successful! You can now <a href='login.php'>Login</a>.";
                } else {
                    $error = "Something went wrong. Try again.";
                }
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - LoVi</title>
  <style>
  body {
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg, #f1f8ff, #e3f2fd);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 10px;
    box-sizing: border-box;
  }

  .auth-container {
    background: #fff;
    padding: 15px 15px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 350px;
    box-sizing: border-box;
  }

  h2 {
    text-align: center;
    margin-bottom: 12px;
    color: #0056b3;
    font-size: 20px;
  }

  .input-group {
    margin-bottom: 8px;
  }

  label {
    font-size: 12px;
    font-weight: 500;
    display: block;
    margin-bottom: 3px;
  }

  input, textarea {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    transition: border 0.3s;
  }

  textarea {
    resize: none;
    height: 50px;
  }

  input:focus, textarea:focus {
    border-color: #0056b3;
    outline: none;
  }

  .btn {
    width: 100%;
    padding: 8px;
    background: #0056b3;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .btn:hover {
    background: #003d80;
  }

  .error, .success {
    font-size: 13px;
    margin-bottom: 8px;
    text-align: center;
  }

  .switch {
    text-align: center;
    margin-top: 10px;
  }

  .switch a {
    color: #0056b3;
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
  }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Register</h2>
    <?php if ($error): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

    <form method="POST">
      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>
      <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="input-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>
      <div class="input-group">
        <label>Address</label>
        <textarea name="address" rows="3" required></textarea>
      </div>
      <div class="input-group">
        <label>Phone Number</label>
        <input type="text" name="phone" required>
      </div>
      <button type="submit" class="btn">Register</button>
    </form>

    <div class="switch">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>
   