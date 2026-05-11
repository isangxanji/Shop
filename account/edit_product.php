<?php
include '../includes/db.php';

// 1. Fetch current product details to fill the form boxes
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $product_data = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $product = mysqli_fetch_assoc($product_data);
    
    // Safety check: if product doesn't exist, go back
    if (!$product) {
        header("Location: MyAccount.php?tab=shop");
        exit();
    }
}

// 2. Handle the "Save Changes" button click
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['product_price']);
    
    $update = "UPDATE products SET product_name='$name', product_price='$price' WHERE id='$id'";
    
    if (mysqli_query($conn, $update)) {
        // Redirect back to the Shop tab in your main dashboard
        header("Location: MyAccount.php?tab=shop&msg=Updated");
        exit();
    }
}

// At the top of account/my_shop.php
$is_editing = isset($_GET['edit_id']);

if ($is_editing) {
    $e_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$e_id'");
    $product = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-container { max-width: 500px; margin: 80px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .edit-container h2 { color: #5D2A18; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        .btn-save { background: #5D2A18; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px; font-weight: bold; transition: 0.3s; }
        .btn-save:hover { background: #4a2113; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
<!--
    <div class="edit-container">
        <h2>Edit Product Details</h2>
        
        <form action="" method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Price (₱)</label>
                <input type="number" step="0.01" name="product_price" value="<?= $product['product_price'] ?>" required>
            </div>

            <button type="submit" name="update_product" class="btn-save">Save Changes</button>
            <a href="MyAccount.php?tab=shop" class="btn-cancel">Cancel and Go Back</a>
        </form>
    </div>
-->
    <div class="shop-management-view">
    <?php if ($is_editing): ?>
        <div class="edit-product-container">
            <div class="form-header">
                <h2><i class="fa-solid fa-pen-to-square"></i> Edit Product</h2>
                <p>Updating details for: <strong><?= htmlspecialchars($product['product_name']) ?></strong></p>
            </div>

            <form action="account/edit_product.php" method="POST" class="product-form">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                
                <div class="form-section">
                    <label>Product Name</label>
                    <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-section">
                        <label>Price (₱)</label>
                        <input type="number" step="0.01" name="product_price" value="<?= $product['product_price'] ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="MyAccount.php?tab=shop" class="cancel-btn">Cancel</a>
                    <button type="submit" name="update_product" class="submit-btn">Save Changes</button>
                </div>
            </form>
        </div>

    <?php else: ?>
        <div class="shop-header">
            <h3>My Inventory</h3>
            <a href="MyAccount.php?tab=add_product" class="add-btn">+ Add New</a>
        </div>

        <div class="product-grid">
            <?php while($item = mysqli_fetch_assoc($products)): ?>
                <div class="product-card">
                    <div class="card-btns">
                        <a href="MyAccount.php?tab=shop&edit_id=<?= $item['id'] ?>" class="buy-now" style="background:#6c757d; text-align:center; text-decoration:none;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a href="MyAccount.php?tab=shop&delete_id=<?= $item['id'] ?>" class="btn-delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>