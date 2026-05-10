<?php
session_start(); // Ensure session is started if not already
include 'includes/db.php';

$shop_id = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $shop_res = mysqli_query($conn, "SELECT id FROM shops WHERE user_id = '$user_id'");
    if ($shop_row = mysqli_fetch_assoc($shop_res)) {
        $shop_id = $shop_row['id'];
    }
}

// 1. Build the Main Products Query (with is_deleted filter)
$query = "SELECT p.*, c.category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.is_deleted = 0"; // Basic filter: only show non-deleted items

// 2. Append Category Filter if active
if (isset($_GET['cat_id'])) {
    $cat_id = mysqli_real_escape_string($conn, $_GET['cat_id']);
    $query .= " AND p.category_id = '$cat_id'";
}

$query .= " ORDER BY p.id DESC";
$home_products = mysqli_query($conn, $query);

// 3. Update the Second Query (Top/Featured Items)
// You MUST add WHERE p.is_deleted = 0 here too, otherwise they show up in the top list!
$top_query = "SELECT p.*, s.shop_name 
              FROM products p 
              JOIN shops s ON p.shop_id = s.id 
              WHERE p.is_deleted = 0
              ORDER BY p.items_sold DESC LIMIT 8";

$result = mysqli_query($conn, $top_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumine | Discover What's Trending</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php" class="active" >Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="Clothing.php">Clothing</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li><a href="MyAccount.php">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <p class="subtitle">NEW COLLECTION 2025</p>
            <h1>Discover What's <br><span>Trending Now</span></h1>
            <p class="description">Shop the latest fashion and electronics from top sellers across the Philippines.</p>
            <div class="hero-btns">
                <button class="btn-primary">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                <button class="btn-secondary">View Clothing</button>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://via.placeholder.com/400" alt="Featured Collection">
        </div>
    </section>

    <section class="products-section">
        <div class="section-header">
            <div>
                <p class="top-selling"><i class="fa-solid fa-chart-line"></i> TOP SELLING</p>
                <h2>Best Sellers</h2>
            </div>
            <a href="Shop.php" class="view-all">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <!--<div class="filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Men's Fashion</button>
            <button class="filter-btn">Women's Fashion</button>
            <button class="filter-btn">Electronics</button>
        </div>-->


        <div class="product-grid">
             <?php 
    // Check if the query actually has results
    if ($home_products && mysqli_num_rows($home_products) > 0): 
        while($item = mysqli_fetch_assoc($result)): 
            // This includes your Buy Now and Add to Cart forms
            include 'includes/product_card.php'; 
        endwhile; 
    else: ?>
        <p>No products found in the shop.</p>
    <?php endif; ?>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <h3>Lumine</h3>
                <p>Your trusted marketplace for fashion and electronics in the Philippines.</p>
            </div>
            <div class="footer-links">
                <h4>NAVIGATE</h4>
                <ul>
                    <li>Home</li>
                    <li>Shop All</li>
                    <li>My Account</li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>CONTACT</h4>
                <p>support@lumine.ph</p>
                <p>+63 2 8888 9999</p>
            </div>
        </div>
    </footer>

</body>
</html>