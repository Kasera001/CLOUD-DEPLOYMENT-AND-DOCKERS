<?php
function get_pdo(): PDO {
    $host = getenv('DB_HOST');
    $name = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');

    if ($host === false || $name === false || $user === false || $pass === false) {
        throw new RuntimeException('Database environment variables are not configured.');
    }

    $dsn  = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}