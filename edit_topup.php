<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    die("Pengguna tidak ditemukan. Silakan login terlebih dahulu.");
}

// Cek apakah ID transaksi ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID transaksi tidak ditemukan. Pastikan Anda mengakses halaman ini dengan tautan yang benar.");
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game = $_POST['game'];
    $amount = $_POST['amount'];
    $sql = "UPDATE topups SET game = ?, amount = ? WHERE topup_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $game, $amount, $id, $user_id);

    if ($stmt->execute()) {
        header("Location: lihat_proses_topup.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Query untuk mengambil data transaksi berdasarkan topup_id dan user_id
$sql = "SELECT * FROM topups WHERE topup_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$topup = $result->fetch_assoc();

if (!$topup) {
    die("Transaksi tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Transaksi</title>
  <style>
    /* Add some basic styling */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 0 auto;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
      margin-bottom: 15px;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Edit Transaksi</h1>
  <form method="post">
    <label>Game:</label>
    <input type="text" name="game" value="<?php echo htmlspecialchars($topup['game']); ?>" required>
    <label>Amount:</label>
    <input type="number" name="amount" value="<?php echo htmlspecialchars($topup['amount']); ?>" required>
    <button type="submit">Update</button>
  </form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
