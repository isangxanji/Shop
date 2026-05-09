<?php
session_start();
include 'includes/db.php';

// 1. Fetch products where category_id is '1' (Clothing)
$query = "SELECT * FROM products WHERE category_id = '1'"; 
$clothing_products = mysqli_query($conn, $query);
$total_items = mysqli_num_rows($clothing_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing | Lumine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="Clothing.php" class="active">Clothing</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li><a href="MyAccount.php">My Account</a></li>
            </ul>
        </nav>
    </header>

    <header class="category-banner">
        <div class="banner-content">
            <div class="category-tag"><i class="fa-solid fa-shirt"></i> CATEGORY</div>
            <h1>Clothing</h1>
            <p>Discover the latest fashion trends for men and women.</p>
        </div>
    </header>

    <main class="container">
        <section class="clothing-controls">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search clothing items...">
            </div>
            
            <div class="sub-categories">
                <button class="pill active">All Clothing</button>
                <button class="pill">Men's Fashion</button>
                <button class="pill">Women's Fashion</button>
            </div>
            
            <p class="item-count">Showing <strong><?php echo $total_items; ?></strong> clothing items</p>
        </section>

        <section class="shop-container">    
            <div class="product-grid">
                <?php 
    // Check if the query actually has results
    if ($clothing_products && mysqli_num_rows($clothing_products) > 0): 
        while($item = mysqli_fetch_assoc($clothing_products)): 
            // This includes your Buy Now and Add to Cart forms
            include 'includes/product_card.php'; 
        endwhile; 
    else: ?>
        <p>No products found in the shop.</p>
    <?php endif; ?>

            </div>
        </section>
    </main>
</body>
</html>