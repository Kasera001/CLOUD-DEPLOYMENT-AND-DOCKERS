<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }

$message = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo  = get_pdo();
        $stmt = $pdo->prepare("INSERT INTO contacts (registration_number, mobile_number, email, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['reg_number'], $_POST['mobile_number'], $_POST['email'], $_POST['address']]);
        $message = "Contact registration saved successfully to the database service!";
    } catch (PDOException $e) {
        $error = ($e->getCode() == 23000)
            ? "Error: This registration number already exists in the system."
            : "Database Write Failure: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Dashboard</title>
<link rel="stylesheet" href="style.css"></head>
<body><div class="card wide">
  <div class="nav">
    <span>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</span>
    <a href="logout.php" class="btn btn-red">Logout</a>
  </div>
  <h2>Register New Contact Detail</h2>
  <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form action="dashboard.php" method="POST">
    <div class="form-group"><label>Registration Number</label>
      <input type="text" name="reg_number" placeholder="e.g., COMP/123/2026" required></div>
    <div class="form-group"><label>Mobile Phone Number</label>
      <input type="text" name="mobile_number" placeholder="e.g., +254712345678" required></div>
    <div class="form-group"><label>Email Address</label>
      <input type="email" name="email" placeholder="user@domain.com" required></div>
    <div class="form-group"><label>Physical Address</label>
      <textarea name="address" placeholder="e.g., Nakuru-Sigor Road, Rongai" required></textarea></div>
    <button type="submit" class="btn-green" style="width:auto">Save Contact Data</button>
    <a href="search.php" class="btn" style="margin-left:10px">Go to Search</a>
  </form>
</div></body></html>