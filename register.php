<?php
// Mulai sesi
session_start();

// Inklusi file koneksi database
include('db.php');

// Cek apakah form registrasi disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input (misalnya, pastikan tidak ada field kosong)
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data pengguna baru ke database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Jika sukses, tampilkan pesan sukses dan arahkan ke halaman login
            $success_message = "Registrasi berhasil! Anda dapat <a href='login.php'>login sekarang</a>";
        } else {
            // Jika gagal, tampilkan pesan error
            $error_message = "Terjadi kesalahan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            background: #1d1d2b;
            color: #fffd82;
            font-family: 'Press Start 2P', cursive;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        
        .card {
            background-color: #2b2d42;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fffd82;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        h3 {
            font-size: 1.5em;
            color: #ff6b6b;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-label, .alert {
            font-size: 0.9em;
            color: #fffd82;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background-color: #1c1b2e;
            color: #fffd82;
            border: 2px solid #ff6b6b;
            border-radius: 5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 5px rgba(255, 107, 107, 0.5);
        }

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            color: #fffd82;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 0.9em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn-primary:hover {
            background-color: #ff4d4d;
            transform: scale(1.05);
        }

        .text-primary {
            color: #ff6b6b !important;
        }

        .text-primary:hover {
            color: #ff4d4d !important;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg p-4">
                <h3>Registrasi</h3>
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success_message ?>
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error_message ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <p class="mt-3">Sudah punya akun? <a href="login.php" class="text-decoration-none text-primary">Login sekarang</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
