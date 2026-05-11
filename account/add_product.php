<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Show all errors for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the uploads folder exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
        echo "Created 'uploads' folder.<br>";
    }
    
    // Check if shop_id is actually in the session
    if (!isset($_SESSION['shop_id'])) {
        die("Error: No Shop ID found in session. Please go to My Shop tab first.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $shop_id = $_SESSION['shop_id'];

    // Handle Image Upload
    $image_name = time() . '_' . $_FILES['product_image']['name']; // Added timestamp to prevent overwriting
    $target_dir = "uploads/";
    
    // Create folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($image_name);

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        $query = "INSERT INTO products (shop_id, category_id, product_name, product_price, stock_quantity, product_image) 
                  VALUES ('$shop_id', '$category', '$name', '$price', '$stock', '$image_name')";
    
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Product Added Successfully!'); window.location='MyAccount.php?tab=shop';</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Failed to upload image. Check if the 'uploads' folder exists and is writable.";
    }
}
?>

<div class="add-product-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-plus-circle"></i> Add New Product</h2>
        <p>Fill in the details below to list a new item in **StyleHouse PH**.</p>
    </div>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?tab=add_product" method="POST" enctype="multipart/form-data" class="product-form">
        
        <div class="form-section">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" placeholder="e.g. Classic Navy Blazer" required>
        </div>

        <div class="form-row">
            <div class="form-section">
                <label for="price">Price (₱)</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-section">
                <label for="stock">Initial Stock</label>
                <input type="number" id="stock" name="stock" placeholder="0" required>
            </div>
        </div>

        <div class="form-section">
            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="1">Clothing</option>
                <option value="2">Electronics</option>
                <option value="3">Home & Living</option>
            </select>
        </div>

        <div class="form-section">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Describe your product..."></textarea>
        </div>

        <div class="form-section">
            <label for="product_image">Product Image</label>
            <div class="upload-box">
                <input type="file" id="product_image" name="product_image" accept="image/*" required>
                <p><i class="fa-solid fa-cloud-arrow-up"></i> Click to upload or drag and drop</p>
            </div>
        </div>

        <div class="form-actions">
            <a href="MyAccount.php?tab=shop" class="cancel-btn">Cancel</a>
            <button type="submit" class="submit-btn">List Product</button>
        </div>
    </form>
</div>