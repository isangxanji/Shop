<?php
include 'includes/db.php'; // 2. Fixes the "Failed to open stream" error by going up one folder

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Pathing fix for redirect
    exit();
}

$user_id = $_SESSION['user_id'];

// 3. This now works because $conn is successfully included from ../includes/db.php
$fetch_query = "SELECT * FROM users WHERE id = '$user_id'";
$res = mysqli_query($conn, $fetch_query);
$user_data = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    $update_sql = "UPDATE users SET 
                   full_name = '$full_name', 
                   email = '$email', 
                   phone = '$phone', 
                   address = '$address',
                   bio = '$bio' 
                   WHERE id = '$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Profile Updated!'); window.location.href='MyAccount.php';</script>";
        exit();
    }
}
?>

<link rel="stylesheet" href="../style.css">

<div class="edit-profile-container">
    <div class="card-header">
        <h3><i class="fa-solid fa-user-pen"></i> Edit Personal Information</h3>
    </div>

    <?php if(isset($_SESSION['error_msg'])): ?>
        <div style="color: #721c24; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
        </div>
    <?php endif; ?>
    
    <form action="MyAccount.php" method="POST">
        <div class="info-grid">
            <div class="info-group">
                <label>FULL NAME</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>
            
            <div class="info-group">
                <label>EMAIL ADDRESS</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="info-group">
                <label>PHONE NUMBER</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>

            <div class="info-group">
                <label>ADDRESS</label>
                <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
            </div>

            <div class="info-group" style="grid-column: span 2;">
                <label>BIO</label>
                <textarea name="bio" rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
            <h4 style="color: #4a2c2a; margin-bottom: 15px;"><i class="fa-solid fa-shield-halved"></i> Change Password</h4>
            <div class="info-grid">
                <div class="info-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" placeholder="Verify old password">
                </div>
                <div class="info-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Enter new password">
                </div>
            </div>
        </div>
        
        <div class="form-actions" style="margin-top: 20px;">
            <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
            <a href="MyAccount.php?tab=profile" class="btn-cancel" style="margin-left: 15px; color: #888; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>