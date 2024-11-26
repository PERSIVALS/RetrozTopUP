<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pastikan data game dikirim melalui POST
if (!isset($_POST['game_name']) || !isset($_POST['publisher'])) {
    header("Location: pilih_game.php");
    exit();
}

// Tangkap data yang dikirim dari pilih_game.php
$game_name = $_POST['game_name'];
$publisher = $_POST['publisher'];

// Produk dan harga spesifik untuk setiap game
$products = [
    'Mobile Legends' => [
        ['value' => 'diamond', 'text' => 'Diamond'],
        ['value' => 'weekly_pass', 'text' => 'Weekly Diamond Pass'],
        ['value' => 'starlight', 'text' => 'Starlight']
    ],
    'PUBG Mobile' => [
        ['value' => 'uc', 'text' => 'UC'],
        ['value' => 'royale_pass', 'text' => 'Royale Pass']
    ],
    'Free Fire' => [
        ['value' => 'diamond_ff', 'text' => 'Diamond'],
        ['value' => 'elite_pass', 'text' => 'Elite Pass']
    ],
    'Valorant' => [
        ['value' => 'vp', 'text' => 'Valorant Points'],
        ['value' => 'battle_pass', 'text' => 'Battle Pass']
    ]
];

// Harga spesifik untuk setiap game
$prices = [
    'Mobile Legends' => [
        '10000' => '10.000 IDR',
        '25000' => '25.000 IDR',
        '50000' => '50.000 IDR',
        '100000' => '100.000 IDR'
    ],
    'PUBG Mobile' => [
        '20000' => '20.000 IDR',
        '60000' => '60.000 IDR',
        '120000' => '120.000 IDR',
        '240000' => '240.000 IDR'
    ],
    'Free Fire' => [
        '15000' => '15.000 IDR',
        '75000' => '75.000 IDR',
        '150000' => '150.000 IDR',
        '300000' => '300.000 IDR'
    ],
    'Valorant' => [
        '25000' => '25.000 IDR',
        '100000' => '100.000 IDR',
        '200000' => '200.000 IDR',
        '400000' => '400.000 IDR'
    ]
];

// Dapatkan produk dan harga berdasarkan game yang dipilih
$game_products = isset($products[$game_name]) ? $products[$game_name] : [];
$game_prices = isset($prices[$game_name]) ? $prices[$game_name] : [];

// Tentukan gambar game berdasarkan nama game
$game_images = [
    'Mobile Legends' => 'Ling.jpg',
    'PUBG Mobile' => '1-68.jpg',
    'Free Fire' => 'images.jpg',
    'Valorant' => 'B110272-Cover-istilah-dalam-valorant-scaled.jpg'
];
$game_image = isset($game_images[$game_name]) ? $game_images[$game_name] : 'default.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up - <?php echo htmlspecialchars($game_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS yang sama seperti sebelumnya */
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #7C3AED;
            --success: #10B981;
            --background: #F9FAFB;
            --surface: #FFFFFF;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --border-color: #E5E7EB;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        body {
            background-image: linear-gradient(135deg, #8BC6EC 0%, #9599E2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: var(--text-primary);
            line-height: 1.5;
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .game-info-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .game-logo {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 3px solid white;
        }

        .game-details h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .publisher-badge {
            display: inline-block;
            padding: 5px 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 8px;
        }

        .topup-card {
            background: var(--surface);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--card-shadow);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .product-option {
            background: var(--background);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .product-option:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .product-option.selected {
            border-color: var(--primary);
            background: rgba(79, 70, 229, 0.1);
        }

        .amount-input {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            width: 100%;
            font-size: 1rem;
            transition: var(--transition);
        }

        .amount-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .price-option {
            background: var(--background);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .price-option:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .price-option.selected {
            border-color: var(--primary);
            background: rgba(79, 70, 229, 0.1);
        }

        .submit-button {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-weight: 600;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        @media (max-width: 768px) {
            .game-info-card {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .product-grid, .price-grid {
                grid-template-columns: 1fr;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Game Information Card -->
        <div class="game-info-card fade-in">
            <img src="images/<?php echo htmlspecialchars($game_image); ?>" 
                 alt="<?php echo htmlspecialchars($game_name); ?>" 
                 class="game-logo">
            <div class="game-details">
                <h1><?php echo htmlspecialchars($game_name); ?></h1>
                <span class="publisher-badge"><?php echo htmlspecialchars($publisher); ?></span>
            </div>
        </div>

        <!-- Top-up Form Card -->
        <div class="topup-card fade-in">
            <form action="proses_topup.php" method="POST">
                <input type="hidden" name="game" value="<?php echo htmlspecialchars($game_name); ?>">
                <input type="hidden" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>">

                <!-- Product Selection -->
                <div class="form-group">
                    <label class="form-label">Pilih Produk</label>
                    <div class="product-grid">
                        <?php foreach ($game_products as $index => $product): ?>
                            <div class="product-option hover-effect <?php echo $index === 0 ? 'selected' : ''; ?>"
                                 onclick="selectProduct(this, '<?php echo htmlspecialchars($product['value']); ?>')">
                                <h4><?php echo htmlspecialchars($product['text']); ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="product" id="selected_product" 
                           value="<?php echo !empty($game_products) ? htmlspecialchars($game_products[0]['value']) : ''; ?>">
                </div>

                <!-- Amount Input -->
                <div class="form-group">
                    <label class="form-label" for="amount">Jumlah Top-Up</label>
                    <input type="number" id="amount" name="amount" required min="1" 
                           class="amount-input" placeholder="Masukkan jumlah yang diinginkan">
                </div>

                <!-- Price Selection -->
                <div class="form-group">
                    <label class="form-label">Pilih Nominal</label>
                    <div class="price-grid">
                        <?php foreach ($game_prices as $value => $text): ?>
                            <div class="price-option hover-effect"
                                 onclick="selectPrice(this, '<?php echo htmlspecialchars($value); ?>')">
                                <div class="price-value"><?php echo htmlspecialchars($text); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="price" id="selected_price" value="">
                </div>

                <button type="submit" class="submit-button hover-effect">
                    Lanjutkan Top-Up
                </button>
            </form>
        </div>
    </div>

    <script>
        function selectProduct(element, value) {
            document.querySelectorAll('.product-option').forEach(el => {
                el.classList.remove('selected');
            });
            element.classList.add('selected');
            document.getElementById('selected_product').value = value;
        }

        function selectPrice(element, value) {
            document.querySelectorAll('.price-option').forEach(el => {
                el.classList.remove('selected');
            });
            element.classList.add('selected');
            document.getElementById('selected_price').value = value;
        }
    </script>
</body>
</html>