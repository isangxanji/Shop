<div class="product-card">
    <div class="product-img">
        <span class="badge">BEST SELLER</span>
        <img src="uploads/<?php echo $item['product_image']; ?>" alt="Product Image">
    </div>

    <div class="product-info">
        <small>Shop: 
            <a href="SellerProfile.php?id=<?= $item['shop_id'] ?>">
                <?= htmlspecialchars($item['shop_name'] ?? 'Official Store') ?>
            </a>
        </small>
        <div class="rating">★★★★☆ <span>(312)</span></div>
        <p class="price">₱<?php echo number_format($item['product_price'], 2); ?></p>

        <div class="card-btns">
            <a href="checkout.php?id=<?php echo $item['id']; ?>" class="buy-now" style="text-decoration: none; text-align: center; display: inline-block;">
                Buy Now
            </a>

            <form action="account/add_to_cart.php" method="POST" class="add-form">
                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                <button type="submit" class="add-cart">Add</button>
            </form>
        </div>
    </div>
</div>