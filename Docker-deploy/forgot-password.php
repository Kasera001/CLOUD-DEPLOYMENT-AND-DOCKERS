<?php
require 'db.php';

$message = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    try {
        $pdo  = get_pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $token = bin2hex(random_bytes(16));
            $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?")->execute([$token, $email]);

            $link    = "http://localhost:8080/reset-password.php?token=" . $token;
            $subject = "Password Reset Request - Distributed Demo App";
            $body    = "Hello,\n\nYou requested a password reset. Click the link below to change it:\n\n"
                     . $link . "\n\nIf you did not request this, please ignore this message.";
            $headers = "From: system-noreply@kabarak.ac.ke\r\nReply-To: support@kabarak.ac.ke\r\n"
                     . "X-Mailer: PHP/" . phpversion();

            if (mail($email, $subject, $body, $headers)) {
                $message = "A reset password message has been sent. Check Mailpit at http://localhost:8025";
            } else {
                $error = "Failed to dispatch email over the mail server network.";
            }
        } else {
            $error = "No user account found matching that email address.";
        }
    } catch (PDOException $e) {
        $error = "Database link error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Forgot Password</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="card">
  <h2>Reset Password</h2>
  <p style="text-align:center;color:#666;font-size:14px;">Enter your registration email to request a reset link.</p>
  <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form action="forgot-password.php" method="POST">
    <div class="form-group"><label>Your Account Email</label>
      <input type="email" name="email" placeholder="e.g., admin@kabarak.ac.ke" required></div>
    <button type="submit">Send Reset Message</button>
  </form>
  <div class="links"><a href="index.php">&larr; Back to Login Screen</a></div>
</div></body></html>