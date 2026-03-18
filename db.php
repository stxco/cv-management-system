<?php
// Database configuration for your Aston Server credentials
$host = 'localhost'; 
$db   = 'dg250379035_db'; 
$user = 'USERNAME'; 
$pass = 'PASSWORD';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Security: We don't show specific errors to public users in production
     die("Connection failed. Please try again later.");
}
?>