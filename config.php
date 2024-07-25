<?php
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
try {
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    session_start();
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>