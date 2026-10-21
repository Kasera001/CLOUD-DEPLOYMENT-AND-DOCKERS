<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }

$results = [];
$error = "";
$registration_number = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $registration_number = trim($_POST["registration_number"] ?? "");
    if ($registration_number === "") {
        $error = "Please enter a registration number.";
    } else {
        try {
            $pdo  = get_pdo();
            $stmt = $pdo->prepare("SELECT id, registration_number, mobile_number, email, address, created_at
                                   FROM contacts WHERE registration_number = ?");
            $stmt->execute([$registration_number]);
            $results = $stmt->fetchAll();
            if (count($results) === 0) { $error = "No contact record found for that registration number."; }
        } catch (PDOException $e) {
            error_log("Contact search failed: " . $e->getMessage());
            $error = "The search could not be completed. Please try again.";
        }
    }
}
function h(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Contact Records</title><link rel="stylesheet" href="style.css"></head>
<body><div class="card wide" style="max-width:900px">
  <h2>Search Contact Records</h2>
  <form method="POST" action="search.php">
    <div class="form-group"><label for="registration_number">Registration Number</label>
      <input type="text" id="registration_number" name="registration_number"
             value="<?= h($registration_number) ?>" placeholder="Enter registration number" required></div>
    <button type="submit">Search Service</button>
  </form>

  <?php if ($error !== ""): ?><div class="alert alert-danger" style="margin-top:15px"><?= h($error) ?></div><?php endif; ?>

  <?php if (!empty($results)): ?>
  <table>
    <thead><tr><th>ID</th><th>Registration Number</th><th>Mobile</th><th>Email</th><th>Address</th><th>Date Created</th></tr></thead>
    <tbody>
    <?php foreach ($results as $r): ?>
      <tr><td><?= h($r['id']) ?></td><td><?= h($r['registration_number']) ?></td><td><?= h($r['mobile_number']) ?></td>
          <td><?= h($r['email']) ?></td><td><?= h($r['address']) ?></td><td><?= h($r['created_at']) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>

  <div class="links" style="display:flex;gap:20px;justify-content:center">
    <a href="dashboard.php">Back to Dashboard</a><a href="logout.php">Logout</a>
  </div>
</div></body></html>