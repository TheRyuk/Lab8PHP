<?php
$servername = "localhost";
$username = "root";
$password = "1111";
$dbname="product_ms";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>