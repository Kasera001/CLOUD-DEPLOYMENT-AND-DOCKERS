<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) { header("Location: dashboard.php"); exit; }

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo  = get_pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_POST['username']]);
        $u = $stmt->fetch();

        if ($u && password_verify($_POST['password'], $u['password'])) {
            $_SESSION['user_id']  = $u['id'];
            $_SESSION['username'] = $u['username'];
            header("Location: dashboard.php"); exit;
        }
        $error = "Invalid username or password!";
    } catch (PDOException $e) {
        $error = "Database Connection Failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Login</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="card">
  <h2>System Login</h2>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form action="index.php" method="POST">
    <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <button type="submit">Login</button>
  </form>
  <div class="links">
    <a href="forgot-password.php">Forgot Password?</a><br><br>
    <a href="register.php" style="color:#28a745;">Create New Account</a>
  </div>
</div></body></html>