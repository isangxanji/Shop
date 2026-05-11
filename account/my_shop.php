<?php
// 1. Fixed Path: ../ means "go out of the account folder" to find 'includes'
include 'includes/db.php'; 



// 2. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Go up to find login.php in the root
    exit();
}

$user_id = $_SESSION['user_id'];

// 3. DELETE LOGIC (This was line 20 where your error happened)
if (isset($_GET['delete_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // This is the query that changes the 0 to a 1
    $sql = "UPDATE products SET is_deleted = 1 WHERE id = '$product_id'";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect back to refresh the view
        header("Location: ../MyAccount.php?tab=shop");
        exit();
    }
}


$edit_mode = false;
if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
    $edit_res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$edit_id'");
    $edit_product = mysqli_fetch_assoc($edit_res);
}

// Handle the update action
if (isset($_POST['save_update'])) {
    $p_id = $_POST['p_id'];
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
    
    mysqli_query($conn, "UPDATE products SET product_name='$p_name', product_price='$p_price' WHERE id='$p_id'");
    echo "<script>window.location='MyAccount.php?tab=shop';</script>";
}


// 4. Fetch the shop and products
$shop_query = mysqli_query($conn, "SELECT * FROM shops WHERE user_id = '$user_id'");
$shop = mysqli_fetch_assoc($shop_query);
$has_shop = ($shop) ? true : false;

$products = null;
if ($has_shop) {
    // Add 'AND p.is_deleted = 0' to the WHERE clause
    $products_query = "SELECT p.*, c.category_name, s.shop_name 
                       FROM products p 
                       LEFT JOIN categories c ON p.category_id = c.id 
                       JOIN shops s ON p.shop_id = s.id 
                       WHERE s.user_id = '$user_id' 
                       AND p.is_deleted = 0
                       ORDER BY p.id DESC";
                       
    $products = mysqli_query($conn, $products_query);
}
?>



<link rel="stylesheet" href="../style.css">

<div class="shop-dashboard">
    <?php if ($has_shop):  ?>
        <div class="shop-banner-card">
            <div class="shop-info-main">
                <div class="shop-header-flex">
                    <div class="shop-icon-wrapper" style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px;">
                        <i class="fa-solid fa-shop" style="font-size: 24px;"></i>
                    </div>
                    <div class="shop-details">
                        <div class="shop-title-row" style="display: flex; align-items: center; gap: 10px;">
                            <h2><?php echo htmlspecialchars($shop['shop_name']); ?></h2>
                            <span class="status-indicator active">● Active</span>
                        </div>
                        <p class="shop-subtext">Active Seller • Since 2023</p>
                    </div>
                </div>
            </div>

            <div class="shop-metrics-grid">
                <div class="metric-item">
                    <i class="fa-solid fa-box"></i>
                    <div class="metric-val">
                        <strong>2</strong>
                        <small>Products</small>
                    </div>
                </div>
                <div class="metric-item">
                    <i class="fa-solid fa-chart-line"></i>
                    <div class="metric-val">
                        <strong>724</strong>
                        <small>Total Sold</small>
                    </div>
                </div>
                <div class="metric-item">
                    <i class="fa-solid fa-peseta-sign"></i>
                    <div class="metric-val">
                        <strong><strong>₱<?php echo number_format($shop['total_revenue'], 2); ?></strong></strong>
                        <small>Revenue</small>
                    </div>
                </div>
            </div>
        </div>
        </div> <div class="inventory-header" style="margin: 20px 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: #4a2c2a;"><i class="fa-solid fa-cubes"></i> My Products</h3>
            <a href="MyAccount.php?tab=add_product" class="add-product-btn" style="background: #4a2c2a; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                <i class="fa-solid fa-plus"></i> Add Product
            </a>
        </div>

        <div class="product-grid">
            <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
                <?php while($item = mysqli_fetch_assoc($products)): ?>
                <div class="product-card">
                    <div class="product-imag">
                        <span class="badge">BEST SELLER</span>
                        <img src="uploads/<?php echo $item['product_image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    </div>
    
                    <div class="product-info">
                        <small class="category">
                            <?php echo strtoupper(htmlspecialchars($item['category_name'])); ?>
                        </small>
                        <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                        <div class="rating">★★★★☆ <span>(312)</span></div>
                        <p class="price">₱<?php echo number_format($item['product_price'], 2); ?></p>
        
                        <div class="card-btns">
                            <a href="MyAccount.php?tab=shop&edit_id=<?= $item['id'] ?>" class="buy-now" style="text-align:center; text-decoration:none; background-color: #6c757d;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            

                            <a href="MyAccount.php?delete_id=<?php echo $item['id']; ?>" 
                                class="btn-delete" style="background: white; border: 1px solid #ddd; padding: 10px; border-radius: 5px; color: #4a2c2a;"
                                onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php else: ?>
        <div class="shop-banner-card shop-banner-empty">
            <div class="shop-icon-wrapper">
                <i class="fa-solid fa-store" style="font-size: 40px;"></i>
            </div>

            <div class="inventory-header">
                <h2>You don't have a shop yet</h2>
                <a href="MyAccount.php?tab=create_shop" class="add-product-btn">
                    <i class="fa-solid fa-plus"></i> Create Shop
                </a>
            </div>

        </div>

        <?php endif; ?>
</div>
