<?php
require 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $rows = $pdo->query("SELECT * FROM contacts ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Saved Contacts</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-4">
<h2>Saved Contacts</h2>
<table class="table table-striped">
    <tr>
        <th>#</th><th>First name</th><th>Last name</th>
        <th>Phone</th><th>Email</th><th>Address</th><th>Saved at</th>
    </tr>
    <?php foreach ($rows as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['fname']) ?></td>
        <td><?= htmlspecialchars($row['lname']) ?></td>
        <td><?= htmlspecialchars($row['contactno']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="index.html">Back to the form</a>
</body>
</html>