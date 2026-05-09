<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

//fetch information from db
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?"; 
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

//if wala sa db and user
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$shop_check = mysqli_query($conn, "SELECT * FROM shops WHERE user_id = '$user_id'");
$has_shop = mysqli_num_rows($shop_check) > 0;

if ($has_shop){
    $shop = mysqli_fetch_assoc($shop_check);
}
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';

// order
$order_query = "SELECT o.*, p.product_name, p.product_image 
                FROM orders o 
                JOIN products p ON o.product_id = p.id 
                WHERE o.user_id = '$user_id' 
                ORDER BY o.order_date DESC";
$order_result = mysqli_query($conn, $order_query);

// cart
$cart_query = "SELECT c.*, p.product_name, p.product_image, p.product_price 
               FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Lumine</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="MyAccount.php" class="active">My Account <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <div class="nav-icons"><i class="fa-solid fa-cart-shopping"></i></div>
        </nav>
    </header>

    <main class="account-container">
        <header class="dashboard-header">
            <p class="label-accent">DASHBOARD</p>
            <h1>My Account</h1>
        </header>

        <div class="dashboard-layout">
            <aside class="profile-sidebar">
                <div class="profile-card">
                    <div class="card-header-bg"></div>
                    <div class="user-avatar">
                        <img src="<?= !empty($user['profile_img']) ? $user['profile_img'] : 'uploads/default_user.jpg' ?>" alt="User">
                        <form action="account/upload_avatar_icon.php" method="POST" enctype="multipart/form-data" id="avatarForm">
                            <label for="avatar_input" class="edit-avatar-icon">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" id="avatar_input" name="avatar" accept="image/*" style="display:none;" onchange="document.getElementById('avatarForm').submit();">
                        </form>
                    </div>
                    <div class="user-identity">
                        <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                        <p class="email"><?php echo htmlspecialchars($user['email']); ?></p>
                        <span class="seller-tag">
                            <i class="fa-solid fa-shop"></i>
                            <?php echo htmlspecialchars($user['shop_name'] ?? 'Lumine Member'); ?>
                            <small>Seller</small>
                        </span>
                        <p class="bio"><?php echo htmlspecialchars($user['bio'] ?? 'No bio yet.'); ?></p>
                    </div>
                    <div class="user-stats">
                        <div class="stat"><strong><?php echo $user['order_count'] ?? 0; ?></strong><small>Orders</small></div>
                        <div class="stat"><strong><?php echo $user['rating'] ?? '0.0'; ?>★</strong><small>Reviews</small></div>
                        <div class="stat"><strong><?php echo $user['sale_count'] ?? 0; ?></strong><small>Sales</small></div>
                        <div class="stat"><strong>₱<?php echo number_format($user['revenue'] ?? 0); ?></strong><small>Revenue</small></div>
                    </div>
                </div>
            </aside>

            <?php
            // current tab nga active
            $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
            ?>

            <section class="account-content">
                <nav class="tab-nav">
                    <a href="MyAccount.php?tab=profile" 
                       class="tab-btn <?= ($current_tab == 'profile') ? 'active' : '' ?>">Profile</a>
           
                <a href="MyAccount.php?tab=orders" 
                    class="tab-btn <?= ($current_tab == 'orders') ? 'active' : '' ?>">My Orders</a>
           
                <a href="MyAccount.php?tab=shop" 
                    class="tab-btn <?= ($current_tab == 'shop' || $current_tab == 'add_product') ? 'active' : '' ?>">My Shop</a>
           
                <a href="MyAccount.php?tab=sales" 
                        class="tab-btn <?= ($current_tab == 'sales') ? 'active' : '' ?>">Sales</a>
                
                </nav>

            <div class="tab-display-area">
                <?php
                // This is where the magic happens!
                switch ($current_tab) {
                case 'orders': include 'account/my_order.php'; break;
                case 'shop':   include 'account/my_shop.php'; break;
                case 'sales':  include 'account/my_sales.php'; break;
                case 'add_product': include 'account/add_product.php'; break;
                case 'create_shop': include 'account/create_shop.php'; break;
                default:       include 'account/my_profile.php'; break;
                }
                ?>
            </div>
            </section>
        </div>
    </main>

    
    </body>
</html>