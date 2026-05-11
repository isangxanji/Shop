<?php
session_start();
include '../includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $file = $_FILES['avatar'];

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = "user_" . $user_id . "_" . time() . "." . $extension;
    
    $uploadPath = "../uploads/" . $newFileName;
    $dbPath = "uploads/" . $newFileName;

    if (!is_dir('../uploads')) {
        mkdir('../uploads', 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $sql = "UPDATE users SET profile_img = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $dbPath, $user_id);
        
        if ($stmt->execute()) {
            header("Location: ../MyAccount.php?success=1");
            exit();
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Failed to move uploaded file.";
    }
}
?>

<form action="upload_avatar.php" method="POST" enctype="multipart/form-data" class="avatar-upload-form">
    <label for="avatar_input" class="edit-avatar-icon">
        <i class="fa-solid fa-camera"></i>
    </label>
    <input type="file" id="avatar_input" name="avatar" onchange="this.form.submit()" style="display:none;">
</form>