<?php
session_start();
include 'includes/db.php';

// 1. Fetch products where category_id is '2' (Electronics)
// Optimized Electronics.php (Same for Clothing)
$query = "SELECT p.*, s.shop_name 
          FROM products p 
          JOIN shops s ON p.shop_id = s.id 
          WHERE p.category_id = 2 AND p.is_deleted = 0"; // Use 2
$result = mysqli_query($conn, $query);
$total_items = mysqli_num_rows($result); // Get the count from the correct query

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="electronics.css">
    
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="Clothing.php">Clothing</a></li>
                <li><a href="Electronics.php" class="active">Electronics</a></li>
                <li><a href="MyAccount.php">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons"><i class="fa-solid fa-cart-shopping"></i></div>
        </nav>
    </header>

    <header class="category-banner tech-bg">
        <div class="banner-content">
            <div class="category-tag"><i class="fa-solid fa-microchip"></i> CATEGORY</div>
            <h1>Electronics</h1>
            <p>Top-rated gadgets and tech products from verified sellers.</p>
        </div>
    </header>

    <main class="container">
        <div class="search-section">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search electronics...">
            </div>
        </div>

        <section class="stats-grid">
            <div class="stat-card">
                <h3>4</h3>
                <p>Products</p>
            </div>
            <div class="stat-card">
                <h3>4.8<i class="fa-solid fa-star"></i></h3>
                <p>Top Rated</p>
            </div>
            <div class="stat-card">
                <h3>3</h3>
                <p>Sellers</p>
            </div>
            <div class="stat-card">
                <h3>$267</h3>
                <p>Avg. Price</p>
            </div>
        </section>

        <p class="results-info">Showing <strong>4</strong> electronics</p>

        <section class="product-grid">
            <div class="product-card">
                <div class="product-img">
                    <span class="badge top-pick">TOP PICK</span>
                    <img src="https://via.placeholder.com/250x250" alt="Headphones">
                </div>
                <div class="product-info">
                    <p class="label">ELECTRONICS</p>
                    <h3>Pro Wireless Headphones</h3>
                    <div class="rating">★★★★★ <span>(621)</span></div>
                    <p class="price">$199.99</p>
                    <div class="card-btns">
                        <button class="btn-buy">Buy Now</button>
                        <button class="btn-add">Add</button>
                    </div>
                </div>
            </div>

            <?php 
    // Check if the query actually has results
    if ($result && mysqli_num_rows($result) > 0): 
        while($item = mysqli_fetch_assoc($result)): 
            // This includes your Buy Now and Add to Cart forms
            include 'includes/product_card.php'; 
        endwhile; 
    else: ?>
        <p>No products found in the shop.</p>
    <?php endif; ?>

            </section>
    </main>

    </body>
</html>