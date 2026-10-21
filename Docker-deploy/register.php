<?php
session_start();
require 'db.php';

$message = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo  = get_pdo();
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([trim($_POST['username']), trim($_POST['email']), $hash]);
        $message = "Account created successfully! You can now log in.";
    } catch (PDOException $e) {
        $error = ($e->getCode() == 23000)
            ? "Error: That username or email address is already registered."
            : "Database Write Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Register Account</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="card">
  <h2>Create Account</h2>
  <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form action="register.php" method="POST">
    <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
    <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <button type="submit" class="btn-green">Sign Up</button>
  </form>
  <div class="links"><a href="index.php">&larr; Already have an account? Login</a></div>
</div></body></html>