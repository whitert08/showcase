<?php
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";

try {
  $conn = new PDO("mysql:host=$dbservername;dbname=interview", $dbusername, $dbpassword);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
