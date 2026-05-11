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
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Main Container */
    .login-container {
      min-height: calc(100vh - 72px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 50px 8%;
      background: linear-gradient(135deg, #F9F7F5 0%, #F4ECE6 100%);
    }

    /* Login Box */
    .login-box {
      width: 100%;
      max-width: 430px;
      background: #fff;
      padding: 38px;
      border-radius: 18px;
      border: 1px solid #eee;
      box-shadow: 0 20px 45px rgba(93, 42, 24, 0.12);
    }

    .login-box h2 {
      color: #4B2416;
      font-family: Georgia, serif;
      font-size: 32px;
      text-align: center;
      margin-bottom: 28px; /* Adjusted to replace subtitle spacing */
    }

    .login-box label {
      display: block;
      font-size: 12px;
      font-weight: bold;
      color: #555;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 13px 14px;
      margin-bottom: 18px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background: #fff;
      font-size: 14px;
      outline: none;
    }

    .login-box input:focus {
      border-color: #A67558;
      box-shadow: 0 0 0 3px rgba(166, 117, 88, 0.15);
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 22px;
    }

    .remember label {
      margin: 0;
      text-transform: none;
      font-size: 13px;
      color: #666;
      font-weight: 500;
    }

    /* Button Styling */
    .login-box button {
      width: 100%;
      border: none;
      border-radius: 10px;
      padding: 13px;
      background: #4B2416;
      color: #fff;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .login-box button:hover {
      background: #7C442A;
      transform: translateY(-1px);
    }

    /* Bottom Links */
    .links {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      font-size: 14px;
    }

    .links a,
    .login-box a {
      color: #7C442A;
      text-decoration: none;
      font-weight: 600;
    }

    .links a:hover,
    .login-box a:hover {
      color: #4B2416;
      text-decoration: underline;
    }

    /* Error Message */
    .error-msg {
      background: #FFF3F0;
      color: #C0392B;
      border: 1px solid #F3C5BC;
      border-radius: 10px;
      padding: 10px 12px;
      font-size: 13px;
      margin-bottom: 18px;
      text-align: center;
    }

    @media (max-width: 700px) {
      .navbar {
        flex-direction: column;
        gap: 15px;
        padding: 20px 20px;
      }

      .nav-links {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
      }

      .login-box {
        padding: 28px 22px;
      }
    }
  </style>
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
    <form class="login-box" action="Home.php" method="POST" >
      <h2>Welcome Back!</h2>
      <?php if(isset($error)): ?>
        <p style="color: red; font-size: 13px; margin-bottom: 10px;"><?= $error ?></p>
      <?php endif; ?>
      <label>Email Address</label>
      <input type="email" name= "email" placeholder="Enter your email"  required/>
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required />
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