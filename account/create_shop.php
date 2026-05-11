<?php
include 'includes/db.php'; 



// Debugging: Check if user is actually logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to create a shop.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
    $description = mysqli_real_escape_string($conn, $_POST['shop_description']);
    $user_id = $_SESSION['user_id'];

    // Handle Logo Upload
    $logo = "default_shop.jpg"; 
    if (!empty($_FILES['shop_logo']['name'])) {
        $logo = time() . '_' . $_FILES['shop_logo']['name'];
        move_uploaded_file($_FILES['shop_logo']['tmp_name'], "uploads/" . $logo);
    }

    $query = "INSERT INTO shops (user_id, shop_name, shop_description, shop_logo, total_revenue) 
              VALUES ('$user_id', '$shop_name', '$description', '$logo', 0.00)";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Shop Created Successfully!'); window.location='MyAccount.php?tab=shop';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Your Shop</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <h2>Set Up Your Shop</h2>
        <form action="create_shop.php" method="POST" enctype="multipart/form-data">
            <label>Shop Name</label>
            <input type="text" name="shop_name" placeholder="e.g. Jd Salac Official Shop" required>
            
            <label>Description</label>
            <textarea name="shop_description" placeholder="Welcome to my new shop!"></textarea>
            
            <label>Shop Logo</label>
            <input type="file" name="shop_logo" accept="image/*">
            
            <button type="submit" class="submit-btn">Launch Shop</button>
            <a href="MyAccount.php?tab=shop" class="cancel-link">Cancel</a>
        </form>
    </div>
</body>
</html>