<?php
session_start();
require 'db.php';

$message = $error = "";
$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$user_record = null;

try { $pdo = get_pdo(); } catch (PDOException $e) { die("Database Connection Error: " . $e->getMessage()); }

if ($token === '') {
    $error = "Invalid or expired security validation token.";
} else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user_record = $stmt->fetch();
    if (!$user_record) { $error = "The token is invalid or has already been used to reset a password."; }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$error) {
    $new = $_POST['password'];
    if (!empty($new)) {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE id = ?")
            ->execute([$hash, $user_record['id']]);
        $message = "Your password has been successfully updated! You can now log in.";
    } else {
        $error = "Please enter a valid password string.";
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Reset Password</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="card">
  <h2>Update Password</h2>
  <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if (!$message && !$error): ?>
  <form action="reset-password.php?token=<?= htmlspecialchars($token) ?>" method="POST">
    <div class="form-group"><label>Enter New Password</label>
      <input type="password" name="password" required placeholder="Type new password"></div>
    <button type="submit">Update Password Record</button>
  </form>
  <?php endif; ?>
  <div class="links"><a href="index.php">&larr; Go to Login Page</a></div>
</div></body></html>