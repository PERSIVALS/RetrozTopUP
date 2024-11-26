<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    die("Pengguna tidak ditemukan. Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

// Fungsi untuk memperbarui status top-up
if (isset($_POST['update_status'])) {
    $topup_id = $_POST['topup_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE topups SET status = ? WHERE topup_id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $new_status, $topup_id, $user_id);
    $update_stmt->execute();
    $update_stmt->close();
    
    // Refresh halaman untuk memperbarui tampilan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Query untuk mengambil daftar transaksi top-up
$sql = "SELECT t.topup_id, t.game, t.amount, t.status, t.created_at, u.username 
        FROM topups t 
        INNER JOIN users u ON t.user_id = u.user_id 
        WHERE t.user_id = ? 
        ORDER BY t.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi Top-Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1b1b1b;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            margin-top: 30px;
        }
        .table {
            background-color: #2c2c2c;
            color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background-color: #6a11cb;
            color: #ffffff;
            border: none;
        }
        .table td {
            border-color: #3c3c3c;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-success {
            background-color: #28a745;
            color: #fff;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 10px;
            margin-top: 20px;
        }
        .status-pending {
            color: #ffc107;
        }
        .status-success {
            color: #28a745;
        }
        .status-failed {
            color: #dc3545;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Daftar Transaksi Top-Up</h2>
        
        <?php if ($result->num_rows == 0): ?>
            <div class="no-data">
                <h4>Tidak ada transaksi yang ditemukan.</h4>
                <p>Silakan lakukan top-up untuk melihat riwayat transaksi Anda.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Username</th>
                            <th>Game</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['topup_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['game']); ?></td>
                                <td><?php echo number_format($row['amount']); ?></td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    $currentStatus = strtolower($row['status']);
                                    switch($currentStatus) {
                                        case 'pending':
                                            $statusClass = 'status-pending';
                                            break;
                                        case 'success':
                                            $statusClass = 'status-success';
                                            break;
                                        case 'failed':
                                            $statusClass = 'status-failed';
                                            break;
                                    }
                                    ?>
                                    <span class="<?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <?php if ($currentStatus == 'pending'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="topup_id" value="<?php echo $row['topup_id']; ?>">
                                            <input type="hidden" name="new_status" value="success">
                                            <button type="submit" name="update_status" 
                                                    class="btn-action btn-success"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi sukses?');">
                                                Selesai
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="edit_topup.php?id=<?php echo $row['topup_id']; ?>" 
                                       class="btn-action btn-edit">Edit</a>
                                    <a href="delete_topup.php?id=<?php echo $row['topup_id']; ?>" 
                                       class="btn-action btn-delete"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>