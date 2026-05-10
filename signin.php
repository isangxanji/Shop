<?php
session_start();
include 'includes/db.php'; // Ensure this points to your 'shoppee' database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect and Sanitize Input
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Simple Validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // 3. Check if email already exists
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        
        if (mysqli_num_rows($check_email) > 0) {
            $error = "Email is already registered!";
        } else {
            // 4. Securely Hash Password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 5. Insert into Database
            $query = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
            
            if (mysqli_query($conn, $query)) {
                // Success! Redirect to login
                header("Location: login.php?signup=success");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopEase - Create Account</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">ShopEase</div>
    <nav>
      <ul class="nav-links">
        <li><a href="homepage.html">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Clothing</a></li>
        <li><a href="#">Electronics</a></li>
        <li><a href="MyAccount.html">My Account</a></li>
        <!--<li><a href="shopsection.html">Sale</a></li>-->
        <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <li><a href="login.html">Log In</a></li>
      </ul>
    </nav>
  </header>

  <main class="signup-container">
    <form class="signup-box" action ="signin.php" method="POST">

      <h2>Create Your Account</h2>
      <?php if(isset($error)): ?>
        <p style="color: #e74c3c; font-size: 14px; margin-bottom: 10px;"><?= $error ?></p>
      <?php endif; ?>
      <label>Full Name</label>
      <input type="text" name="full_name" placeholder="Enter your full name" required />

      <label>Email Address</label>
      <input type="email" name="email" placeholder="Enter your email" required />

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required />

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Confirm your password" required />


      <button type="submit">Register</button>

      <p class="terms">
        By signing up, you agree to our <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.
      </p>

      <p class="login-link">
        Already have an account? <a href="login.html">Log in ›</a>
      </p>
    </form>
  </main>
</body>
</html>