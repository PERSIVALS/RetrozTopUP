<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: pilih_game.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        /* Tema Retro Games */
        body {
            background-color: #1a1a2e;
            font-family: 'Press Start 2P', cursive;
            color: #fff;
            background-image: url('https://www.transparenttextures.com/patterns/dark-mosaic.png'); /* Pixelated background */
        }

        .card {
            background-color: #0f3460;
            border: 3px solid #e94560;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(233, 69, 96, 0.3);
        }

        .form-control {
            border: 2px solid #e94560;
            background-color: #162447;
            color: #fff;
            font-family: 'Press Start 2P', cursive;
        }

        .form-control:focus {
            border-color: #e94560;
            box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
        }

        .btn-primary {
            background-color: #e94560;
            border: none;
            color: #fff;
            font-family: 'Press Start 2P', cursive;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #f0596c;
            transform: scale(1.05);
        }

        /* Ubah warna teks Login, Username, dan Password menjadi kuning */
        h3, .form-label {
            color: #ffd700;
        }

        .text-decoration-none {
            color: #e94560;
            font-family: 'Press Start 2P', cursive;
        }

        .text-decoration-none:hover {
            color: #f0596c;
        }
    </style>
</head>
<body class="d-flex align-items-center" style="min-height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg p-3">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Login</h3>
                    <?php if (isset($error_message)): ?>
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <p class="text-center mt-3">Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar sekarang</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
