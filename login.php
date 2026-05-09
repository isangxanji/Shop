<?php
session_start();
include 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  //prepare statement
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  //verify
  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];

    //fetch shop id para Home
    $shop_stmt = $conn->prepare("SELECT id FROM shops WHERE user_id = ?");
    $shop_stmt->bind_param("i", $user['id']);
    $shop_stmt->execute();
    $shop_result = $shop_stmt->get_result();

    if ($shop_row = $shop_result->fetch_assoc()) {
             $_SESSION['shop_id'] = $shop_row['id'];
         }


    //cookie and remember me
    if (isset($_POST['remember'])) {
      setcookie("user_email", $email, time() + (86499 * 30), "/", "", true, true);
    }
    header("Location: Home.php");
    exit();
  } else {
    $error = "Invalid email or password.";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopEase - Login</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
 <!-- Navigation -->
  <header class="navbar">
    <div class="logo">ShopEase</div>
    <nav>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Clothing</a></li>
        <li><a href="#">Electronics</a></li>
        <!--<li><a href="shopsection.html">Sale</a></li>-->
        <li><a href="#"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <li><a href="#">My Account</a></li>
      </ul>
    </nav>
  </header>

  <main class="login-container">
    <form class="login-box" action="login.php" method="POST" >
      <h2>Welcome Back!</h2>
      <?php if(isset($error)): ?>
        <p style="color: red; font-size: 13px; margin-bottom: 10px;"><?= $error ?></p>
      <?php endif; ?>
      <label>Email Address</label>
      <input type="email" name= "email" placeholder="Enter your email"  />required
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password"  />required
      <div class="remember">
        <input type="checkbox" id="remember" />
        <label for="remember">Remember Me</label>
      </div>
      <button type="submit">Log in</button>
      <div class="links">
        <a href="#">Forgot Password?</a>
        <a href="signin.php">Sign Up ></a>
      </div>
    </form>
  </main>
</body>
</html>