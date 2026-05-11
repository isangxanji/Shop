<?php
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);
?>



<div class="profile-container">
    <div class="info-card">
        <div class="card-header">
            <h3><i class="fa-regular fa-user"></i> Personal Information</h3>
            <a href="MyAccount.php?tab=edit_profile" class="edit-btn" style="text-decoration: none;">
                <i class="fa-solid fa-pen"></i> Edit Profile
            </a>
        </div>

        <div class="info-grid">
            <div class="info-group">
                <label>FULL NAME</label>
                <p><i class="fa-regular fa-user"></i><?php echo htmlspecialchars($user_data['full_name']); ?></p>
            </div>
            <div class="info-group">
                <label>EMAIL ADDRESS</label>
                <p><i class="fa-regular fa-envelope"></i> <?php echo htmlspecialchars($user_data['email']); ?></p>
            </div>
            <div class="info-group">
                <label>PHONE NUMBER</label>
                <p><i class="fa-solid fa-phone"></i> +</i> <?php echo htmlspecialchars($user_data['phone'] ?? 'Not set'); ?></p>
            </div>
            <div class="info-group">
                <label>ADDRESS</label>
                <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($user_data['address'] ?? 'Not set'); ?></p>
            </div>
        </div>

        <div class="bio-section">
            <label>BIO</label>
            <p><?php echo htmlspecialchars($user_data['bio'] ?? 'Not set'); ?></p>
        </div>

    </div>
</div>