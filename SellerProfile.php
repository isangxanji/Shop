<?php
include 'includes/db.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch shop info
$shop_res = mysqli_query($conn, "SELECT * FROM shops WHERE id = '$id'");
$shop = mysqli_fetch_assoc($shop_res);

// Fetch only ACTIVE products for this specific shop
$products = mysqli_query($conn, "SELECT * FROM products WHERE shop_id = '$id' AND is_deleted = 0");
$products_query = "SELECT * FROM products WHERE shop_id = '$id' AND is_deleted = 0";
$products = mysqli_query($conn, $products_query);
$total_items = mysqli_num_rows($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleHouse PH | Lumine Seller</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="seller.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="Clothing.php">Clothing</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li><a href="MyAccount.php">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons"><i class="fa-solid fa-cart-shopping"></i></div>
        </nav>
    </header>

    <section class="seller-hero">
        <div class="seller-profile-header">
            <div class="store-icon">
                <i class="fa-solid fa-shop"></i>
            </div>
            <div class="store-details">
                <div class="title-row">
                    <h1><?= htmlspecialchars($shop['shop_name']) ?></h1>
                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified</span>
                </div>
                <p class="member-info">Member since 2021 • BGC, Taguig</p>
                <p class="store-bio"><?= htmlspecialchars($shop['shop_description']) ?>.</p>
            </div>
        </div>

        <div class="seller-stats">
            <div class="stat-item">
                <i class="fa-solid fa-box-archive"></i>
                <div class="stat-val"><?= mysqli_num_rows($products) ?></div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-star"></i>
                <div class="stat-val">4.8<span>★</span></div>
                <div class="stat-label">Avg. Rating</div>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-users"></i>
                <div class="stat-val">724</div>
                <div class="stat-label">Total Reviews</div>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-chart-line"></i>
                <div class="stat-val">98%</div>
                <div class="stat-label">Response Rate</div>
            </div>
        </div>
    </section>

    <main class="container">
        <div class="shop-filter-row">
            <div class="text-group">
                <h2>Shop Products</h2>
                <p>2 items listed by StyleHouse PH</p>
            </div>
            <div class="seller-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search products...">
            </div>
        </div>

        <section class="product-grid">
    <?php if ($products && mysqli_num_rows($products) > 0): ?>
        <?php while($item = mysqli_fetch_assoc($products)): ?>
            <div class="product-card">
                <div class="product-img">
                    <img src="uploads/<?= $item['product_image'] ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                </div>
                <div class="product-info">
                    <p class="label">PRODUCT</p>
                    <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                    <p class="price">₱<?= number_format($item['product_price'], 2) ?></p>
                    <div class="card-btns">
                        <button class="btn-buy">Buy Now</button>
                        <button class="btn-add">Add</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-products">
            <p>This shop hasn't listed any products yet.</p>
        </div>
    <?php endif; ?>
</section>
    </main>

    </body>
</html>