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
  <style>
    /* --- Main Container --- */
    .signup-container {
        min-height: calc(100vh - 72px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 50px 8%;
      background: linear-gradient(135deg, #F9F7F5 0%, #F4ECE6 100%);
    }
    /*min-height: calc(100vh - 65px);
    }

    /* --- Signup Box (The Card) --- */
    .signup-box {
        width: 100%;
      max-width: 460px;
      background: #fff;
      padding: 38px;
      border-radius: 18px;
      border: 1px solid #eee;
      box-shadow: 0 20px 45px rgba(93, 42, 24, 0.12);
    }

    .signup-box h2 {
        color: #4B2416;
      font-family: Georgia, serif;
      font-size: 32px;
      text-align: center;
      margin-bottom: 8px;
    }

    /* --- Form Elements --- */
    label {
        display: block;
      font-size: 12px;
      font-weight: bold;
      color: #555;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    input {
        width: 100%;
      padding: 13px 14px;
      margin-bottom: 18px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background: #fff;
      font-size: 14px;
      outline: none;
    }

    input:focus {
        border-color: #A67558;
      box-shadow: 0 0 0 3px rgba(166, 117, 88, 0.15);
    }

    /* --- Register Button --- */
    button[type="submit"] {
        width: 100%;
      border: none;
      border-radius: 10px;
      padding: 13px;
      background: #4B2416;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: 0.2s ease;
      margin-top: 4px;
    }

    button[type="submit"]:hover {
        background: #7C442A;
      transform: translateY(-1px);
    }

    /* --- Footer Links --- */
    .terms {
        text-align: center;
      color: #777;
      font-size: 13px;
      line-height: 1.6;
      margin-top: 18px;
    }

    .terms a {
        color: #7C442A;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link {
        text-align: center;
      color: #777;
      font-size: 13px;
      line-height: 1.6;
      margin-top: 18px;
    }

    .login-link a {
        color: #4B2416;
      text-decoration: underline;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    /* Custom Error Message */
    p[style*="color: #e74c3c"] {
        background-color: #fff5f5;
        border: 1px solid #fed7d7;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
    }
</style>
</style>
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
    <form class="signup-box" action ="login.php" method="POST">

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
        Already have an account? <a href="login.php">Log in ›</a>
      </p>
    </form>
  </main>
</body>
</html>