<?php
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Check if the item is already in the cart
    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
    
    if (mysqli_num_rows($check_cart) > 0) {
        // Increment quantity if it exists
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
    } else {
        // Add new item to cart
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../Shop.php?added=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>