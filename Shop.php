<?php
session_start();
include 'includes/db.php';

// FIX: Define the missing variable $product_query
$product_query = mysqli_query($conn, "SELECT * FROM products");

// Optional: Count items for your "Showing X items" text
$total_items = mysqli_num_rows($product_query);

if (isset($_GET['delete_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // JOIN products with shops to verify the owner
    $delete_query = "DELETE p FROM products p 
                     JOIN shops s ON p.shop_id = s.id 
                     WHERE p.id = '$product_id' AND s.user_id = '$user_id'";
    
    if (mysqli_query($conn, $delete_query)) {
        header("Location: my_shop.php?msg=deleted");
    }
}

$query = "SELECT p.*, s.shop_name 
          FROM products p 
          JOIN shops s ON p.shop_id = s.id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shop.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php" class="active">Shop</a></li>
                <li><a href="Clothing.php">Clothing</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li><a href="MyAccount.php">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </nav>
    </header>

    <main class="shop-container">
        <header class="shop-header">
            <p class="breadcrumb">ALL PRODUCTS</p>
            <h1>Shop</h1>
        </header>

        <section class="controls-section">
            <div class="search-sort-bar">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search products, categories...">
                </div>
                <div class="sort-wrapper">
                    <i class="fa-solid fa-sliders"></i>
                    <select>
                        <option>Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <p class="results-count"><strong>8</strong> products found</p>
        </section>

        <section class="product-grid">
    <?php 
    // Check if the query actually has results
    if ($product_query && mysqli_num_rows($product_query) > 0): 
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