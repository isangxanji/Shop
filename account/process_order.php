<?php
session_start();
include 'includes/db.php';

// Ensure user is logged in and data is sent via POST
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Shop.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$total_amount = $_POST['total_price'];
$status = 'Pending'; // Default status for new orders

// Match the columns in your 'orders' table
$query = "INSERT INTO orders (user_id, product_id, total_amount, status, customer_name, phone, address) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("iidssss", $user_id, $product_id, $total_amount, $status, $customer_name, $phone, $address);

$success = false;
if ($stmt->execute()) {
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation | Lumine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <main class="account-container status-page">
        <div class="profile-card status-card">
            <?php if ($success): ?>
                <div class="status-icon success">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1>Order Placed!</h1>
                <p>Order for <strong><?= htmlspecialchars($customer_name) ?></strong> has been received.</p>
                <div class="status-actions">
                    <a href="MyAccount.php?tab=orders" class="btn-primary">My Orders</a>
                    <a href="Shop.php" class="btn-secondary">Shop More</a>
                </div>
            <?php else: ?>
                <div class="status-icon error">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <h1>Processing Error</h1>
                <p>We couldn't save your order. Error: <?= $conn->error ?></p>
                <a href="checkout.php?id=<?= $product_id ?>" class="btn-primary">Try Again</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>