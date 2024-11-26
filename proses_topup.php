<?php
session_start();
include 'db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tangkap data yang dikirim melalui form
    $game = $_POST['game'] ?? null;
    $product = $_POST['product'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $price = $_POST['price'] ?? null;
    $publisher = $_POST['publisher'] ?? null;

    // Periksa apakah semua data telah diisi
    if ($game && $product && $amount && $price) {
        // Ambil user_id dari session
        $user_id = $_SESSION['user_id'];

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO topups (user_id, game, product, amount, price, publisher, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ississ", $user_id, $game, $product, $amount, $price, $publisher);

        if ($stmt->execute()) {
            echo "Transaksi berhasil ditambahkan!<br>";
            echo '<a href="lihat_proses_topup.php" class="btn btn-primary">Lihat Proses Top-Up</a>';
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Data tidak lengkap. Pastikan semua data diisi.";
    }
} else {
    echo "Akses tidak valid.";
}

$conn->close();
?>
