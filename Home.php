<?php
include 'includes/db.php';

// Check if a category filter was clicked in the UI
$where_clause = "";
if (isset($_GET['cat_id'])) {
    $cat_id = mysqli_real_escape_string($conn, $_GET['cat_id']);
    $where_clause = " WHERE p.category_id = '$cat_id'";
}

// JOIN products with categories to get the 'category_name'
$query = "SELECT p.*, c.category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          $where_clause
          ORDER BY p.id DESC";

// Fetch products for the logged-in shop
$products = mysqli_query($conn, "SELECT * FROM products WHERE shop_id = '$shop_id'");

$home_products = mysqli_query($conn, $query);
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
            <a href="#" class="view-all">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Men's Fashion</button>
            <button class="filter-btn">Women's Fashion</button>
            <button class="filter-btn">Electronics</button>
        </div>

        <div class="product-grid">
            <div class="product-card">
                <div class="product-img">
                    <span class="badge">BEST SELLER</span>
                    <img src="https://via.placeholder.com/250x300" alt="Product">
                </div>
                <div class="product-info">
                    <p class="category">MEN'S FASHION</p>
                    <h3>Classic Navy Blazer</h3>
                    <div class="rating">★★★★☆ <span>(312)</span></div>
                    <p class="price">$129.99</p>
                    <div class="card-btns">
                        <button class="buy-now">Buy Now</button>
                        <button class="add-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-grid">
            <?php if (mysqli_num_rows($home_products) > 0): ?>
                <?php while($item = mysqli_fetch_assoc($home_products)): ?>
                <div class="product-card">
                    <div class="product-imag">
                        <span class="badge">BEST SELLER</span>
                        <img src="account/uploads/<?php echo $item['product_image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    </div>
    
                    <div class="product-info">
                        <small class="category">
                            <?php echo strtoupper(htmlspecialchars($item['category_name'])); ?>
                        </small>
                        <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                        <div class="rating">★★★★☆ <span>(312)</span></div>
                        <p class="price">₱<?php echo number_format($item['product_price'], 2); ?></p>
        
                        <div class="card-btns">
                            <button class="buy-now">Buy Now</button>
                            <button class="add-cart">Add</button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
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