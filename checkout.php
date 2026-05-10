<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: Shop.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = mysqli_real_escape_string($conn, $_GET['id']);
$product = null; 

// 1. Fetch from Cart with Shop Details
$cart_query = "SELECT c.quantity, p.*, s.shop_name 
               FROM cart c 
               JOIN products p ON c.product_id = p.id 
               LEFT JOIN shops s ON p.shop_id = s.id 
               WHERE c.id = '$id' AND c.user_id = '$user_id'";
$res = mysqli_query($conn, $cart_query);

if (mysqli_num_rows($res) > 0) {
    $product = mysqli_fetch_assoc($res);
} else {
    // 2. Fetch Direct Product with Shop Details
    $prod_query = "SELECT p.*, s.shop_name 
                   FROM products p 
                   LEFT JOIN shops s ON p.shop_id = s.id 
                   WHERE p.id = '$id'";
    $res = mysqli_query($conn, $prod_query);
    $product = mysqli_fetch_assoc($res);
}

if (isset($_POST['place_order'])) {
    // 1. Capture the form inputs
    $cust_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // 2. Use them in the INSERT query
    $insert = "INSERT INTO orders (user_id, product_id, quantity, customer_name, phone, address, total_amount, status, order_date) 
               VALUES ('$user_id', '$prod_id', '$quantity', '$cust_name', '$phone', '$address', '$total_amount', 'Pending', NOW())";
    
    if (mysqli_query($conn, $insert)) {
        // Success logic...
    }
}

if (!$product) {
    header("Location: Shop.php");
    exit();
}

// 3. Setup variables for HTML
$quantity = $product['quantity'] ?? 1; 
$subtotal = $product['product_price'] * $quantity;
$shipping_fee = 50.00;
$total_amount = $subtotal + $shipping_fee;

// 4. Handle Order Placement (triggered by the "PLACE ORDER" button)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $prod_id = $product['product_id'] ?? $product['id'];
    
    $insert = "INSERT INTO orders (user_id, product_id, quantity, total_amount, status, order_date) 
               VALUES ('$user_id', '$prod_id', '$quantity', '$total_amount', 'Pending', NOW())";
    
    if (mysqli_query($conn, $insert)) {
        mysqli_query($conn, "DELETE FROM cart WHERE product_id = '$prod_id' AND user_id = '$user_id'");
        $_SESSION['success_msg'] = "Order placed!";
        header("Location: MyAccount.php?tab=orders");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <header>
        <nav class="navbar">
            <div class="logo">Lumine</div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="MyAccount.php">My Account</a></li>
            </ul>
        </nav>
    </header>

    <main class="account-container checkout-page">
        <h1 class="page-title"><i class="fa-solid fa-bag-shopping"></i> Checkout</h1>
        
        <div class="dashboard-layout checkout-grid">
            <section class="profile-card checkout-form-section">
                <h3 class="section-heading">Shipping Information</h3>
                <form action="checkout.php" method="POST" id="checkoutForm">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="total_price" value="<?= $total_amount ?>">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="customer_name" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Complete Address</label>
                        <textarea name="address" required class="form-control textarea-address"></textarea>
                    </div>

                    <h3 class="section-heading">Payment Method</h3>
                    <div class="payment-option-card">
                        <input type="radio" name="payment" value="COD" checked> 
                        <div class="payment-text">
                            <strong>Cash on Delivery (COD)</strong>
                            <p>Pay when you receive the item.</p>
                        </div>
                    </div>
                </form>
            </section>

            <aside class="profile-card summary-section">
                <h3 class="section-heading">Order Summary</h3>
                
                <div class="summary-item-flex">
                    <img src="uploads/<?= $product['product_image'] ?>" class="summary-img">
                    <div class="summary-details">
                        <h4><?= htmlspecialchars($product['product_name']) ?></h4>
                        <small>Shop: <?= htmlspecialchars($product['shop_name']) ?></small>
                        <p class="summary-price">₱<?= number_format($product['product_price'], 2) ?></p>
                    </div>
                </div>

                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Subtotal</span>
                        <span>₱<?= number_format($product['product_price'], 2) ?></span>
                    </div>
                    <div class="price-row">
                        <span>Shipping Fee</span>
                        <span>₱<?= number_format($shipping_fee, 2) ?></span>
                    </div>
                    <div class="price-row total-row">
                        <span>Total</span>
                        <span>₱<?= number_format($total_amount, 2) ?></span>
                    </div>
                </div>

                <form action="" method="POST" id="checkoutForm">
                    <button type="submit" name="place_order" class="place-order-btn">
                    PLACE ORDER
                    </button>
                </form>
                <a href="Shop.php" class="cancel-link">Cancel</a>
            </aside>
        </div>
    </main> 
</body>
</html>