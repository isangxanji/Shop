<?php
include 'includes/db.php'
$id = mysqli_real_escape_string($conn, $_GET['id']);
// Fetch shop info
$shop = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM shops WHERE id = '$id'"));
// Fetch only this shop's products
$products = mysqli_query($conn, "SELECT * FROM products WHERE shop_id = '$id'");
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
                    <h1>StyleHouse PH</h1>
                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified</span>
                </div>
                <p class="member-info">Member since 2021 • BGC, Taguig</p>
                <p class="store-bio">Premium menswear curated for the modern Filipino gentleman. Quality you can feel, style you can trust.</p>
            </div>
        </div>

        <div class="seller-stats">
            <div class="stat-item">
                <i class="fa-solid fa-box-archive"></i>
                <div class="stat-val">2</div>
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
            <div class="product-card">
                <div class="product-img">
                    <span class="badge">BEST SELLER</span>
                    <img src="https://via.placeholder.com/250x300" alt="Navy Blazer">
                </div>
                <div class="product-info">
                    <p class="label">MEN'S FASHION</p>
                    <h3>Classic Navy Blazer</h3>
                    <div class="rating">★★★★☆ <span>(312)</span></div>
                    <p class="price">$129.99</p>
                    <div class="card-btns">
                        <button class="btn-buy">Buy Now</button>
                        <button class="btn-add">Add</button>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-img">
                    <span class="badge premium">PREMIUM</span>
                    <img src="https://via.placeholder.com/250x300" alt="Formal Suit">
                </div>
                <div class="product-info">
                    <p class="label">MEN'S FASHION</p>
                    <h3>Premium Formal Suit</h3>
                    <div class="rating">★★★★★ <span>(412)</span></div>
                    <p class="price">$249.99</p>
                    <div class="card-btns">
                        <button class="btn-buy">Buy Now</button>
                        <button class="btn-add">Add</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    </body>
</html>