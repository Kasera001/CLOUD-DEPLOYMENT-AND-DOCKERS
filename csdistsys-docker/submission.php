<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare(
        "INSERT INTO contacts (fname, lname, contactno, email, address) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $_POST['fname'], $_POST['lname'], $_POST['contactno'],
        $_POST['email'], $_POST['address']
    ]);

    echo "<p>Saved successfully! <a href='index.html'>Back to the form</a></p>";
} catch (PDOException $e) {
    echo "<p>Something went wrong: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='index.html'>Try again</a></p>";
}