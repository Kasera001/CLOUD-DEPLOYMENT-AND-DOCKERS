<?php
session_status();
if (isset($_SESSION['user_id'])){
    header("Location:dashboard.php");
    exit;
}

$error ="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $host = 'db'; 
  $db = 'contact_db'; 
  $user = 'root';
  $pass = 'secret_pass'; 
  $charset = 'utf8mb4'; 
  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try{
// Establish network connection to the isolated database tier container
 $pdo = new PDO($dsn, $user, $pass, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, ]); 
 $username_input = $_POST['username'];
 $password_input = $_POST['password'];
}


// This file implements the login page. It receives the submitted username and password, connects to MySQL through PDO