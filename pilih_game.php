<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Daftar game yang tersedia (didefinisikan langsung)
$games = [
    [
        'game_name' => 'Mobile Legends',
        'game_image' => 'Ling.jpg',
        'publisher' => 'Moonton'
    ],
    [
        'game_name' => 'PUBG Mobile',
        'game_image' => '1-68.jpg',
        'publisher' => 'Tencent Games'
    ],
    [
        'game_name' => 'Free Fire',
        'game_image' => 'images.jpg',
        'publisher' => 'Garena'
    ],
    [
        'game_name' => 'Valorant',
        'game_image' => 'B110272-Cover-istilah-dalam-valorant-scaled.jpg',
        'publisher' => 'Riot Games'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: 'Press Start 2P', cursive;
        }

        .navbar {
            background-color: #0f0f0f !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #ff6b6b !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .nav-link {
            color: #ffffff !important;
            transition: color 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .nav-link:hover {
            color: #ff6b6b !important;
        }

        .game-card {
            background-color: #1a1a1a;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .game-card:hover {
            transform: translateY(-5px);
        }

        .game-logo {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
            filter: brightness(0.8);
        }

        .game-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .game-publisher {
            color: #aaaaaa;
            font-size: 0.9em;
            margin-bottom: 15px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .select-button {
            background-color: #ff6b6b;
            color: #ffffff;
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            transition: background-color 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .select-button:hover {
            background-color: #ff4d4d;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">RetroZ Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pilih_game.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lihat_proses_topup.php">Riwayat Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="text-center mb-5">Pilih Game</h2>
        <p class="text-center mb-5" style="color: #ff6b6b; font-size: 1.2em; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Top-Up Termurah Sejagat Bumi!</p>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($games as $game): ?>
            <div class="col">
                <div class="game-card h-100">
                    <img src="images/<?php echo htmlspecialchars($game['game_image']); ?>" 
                         alt="<?php echo htmlspecialchars($game['game_name']); ?> Logo" 
                         class="game-logo">
                    <div class="card-body">
                        <h5 class="game-title"><?php echo htmlspecialchars($game['game_name']); ?></h5>
                        <p class="game-publisher"><?php echo htmlspecialchars($game['publisher']); ?></p>
                        <form action="topup_amount.php" method="POST">
    <input type="hidden" name="game_name" value="<?php echo htmlspecialchars($game['game_name']); ?>">
    <input type="hidden" name="game_image" value="<?php echo htmlspecialchars($game['game_image']); ?>">
    <input type="hidden" name="publisher" value="<?php echo htmlspecialchars($game['publisher']); ?>">
    <button type="submit" class="btn select-button w-100">Pilih Game</button>
</form>

                    </div>
                </div>
            </div>  
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>