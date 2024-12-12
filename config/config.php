<?php
session_start();
try {
  $pdo = new PDO("mysql:host=localhost;dbname=db_truyentranh", "root", "");
  // Cài đặt chế độ lỗi cho PDO
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed!";
  exit();
}


define("ROOT", dirname(dirname(__DIR__)));///DA_PHP
?>
