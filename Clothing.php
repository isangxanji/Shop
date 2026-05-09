<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="clothing.css">
    
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="Clothing.php" class="active">Clothing</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li><a href="MyAccount.php">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
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
            
            <p class="item-count">Showing <strong>5</strong> clothing items</p>
        </section>

        <section class="product-grid">
            <div class="product-card">
                <div class="product-img">
                    <span class="badge">BEST SELLER</span>
                    <img src="https://via.placeholder.com/250x300" alt="Clothing Item">
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
            </section>
    </main>

    </body>
</html>