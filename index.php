<a href="register.php">Register</a> | 
<a href="login.php">Login</a>
<?php
include 'db.php';

// Ambil data kategori
$products = $conn->query("SELECT * FROM products");


?>


