<?php
// session_start() is already in MyAccount.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Change your query from something like status = 'Confirmed' to:
$orders_query = mysqli_query($conn, "SELECT o.*, p.product_name, p.product_image 
                                     FROM orders o 
                                     JOIN products p ON o.product_id = p.id 
                                     WHERE o.user_id = '$user_id' 
                                     AND (o.status = 'Pending' OR o.status = 'Confirmed') 
                                     ORDER BY o.order_date DESC");

?>

<div class="order-history-container">
    <div class="order-history-header">
        <h2><i class="fa-solid fa-box-open"></i> Order</h2>
        <span class="order-count">3 orders</span>
    </div>

    <div class="order-list">
    <?php if (mysqli_num_rows($order_result) > 0): ?>
        <?php while($order = mysqli_fetch_assoc($order_result)): ?>
            <div class="order-item">
                <div class="order-main-info">
                    <img src="uploads/<?= $order['product_image'] ?>" alt="Product" class="order-img">
                    <div class="order-text">
                        <h3><?php echo htmlspecialchars($order['product_name']); ?></h3>
                        <p class="order-meta">Lumine Shop • <?php echo date('M d, Y', strtotime($order['order_date'])); ?></p>
                        <p class="order-price">₱<?php echo number_format($order['total_amount'], 2); ?></p>
                    </div>
                </div>
                <div class="order-status-group">
                    <span class="status-badge <?php echo strtolower($order['status']); ?>">
                        <?php echo $order['status']; ?>
                    </span>
                    <span class="order-id">#ORD-<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; padding: 20px;">No confirmed orders yet.</p>
    <?php endif; ?>
</div>

<div class="order-history-container">
    <div class="order-history-header">
        <h2><i class="fa-solid fa-box-open"></i> Cart</h2>
        <span class="order-count">3 orders</span>
    </div>

    <div class="order-list" style="margin-top: 20px;">
    <?php if (mysqli_num_rows($cart_result) > 0): ?>
        <?php while($cart_item = mysqli_fetch_assoc($cart_result)): ?>
            <div class="order-item">
                <div class="order-main-info">
                    <img src="uploads/<?= $cart_item['product_image']; ?>" alt="Product" class="order-img">
                    <div class="order-text">
                        <h3><?php echo htmlspecialchars($cart_item['product_name']); ?></h3>
                        <p class="order-meta">Quantity: <?php echo $cart_item['quantity']; ?></p>
                        <p class="order-price">₱<?php echo number_format($cart_item['product_price'] * $cart_item['quantity'], 2); ?></p>
                    </div>
                </div>
                <div class="order-status-group">
                    <a href="checkout.php?id=<?php echo $cart_item['id']; ?>" 
                       style="background:#4a2c2a; color:white; padding:5px 15px; border-radius:4px; text-decoration:none;">
                       Checkout
                    </a>
                    
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; padding: 20px;">Your cart is empty.</p>
    <?php endif; ?>

</div>