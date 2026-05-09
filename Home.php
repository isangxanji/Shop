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