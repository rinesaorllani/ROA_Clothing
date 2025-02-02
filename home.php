<?php
session_start();
    if(!isset($_SESSION["userId"])){
        header("Location:login.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styleA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
    
<body>
  <section id="header">
    <a href="home.php" class="navbar-logo"><img src="/imgweb/logo.png" class="logo" alt="Logo" style="width: 75px;"></a>
    <div>
      <ul id="navbar">
        <li><a class="active" href="/home.php">Home</a></li>
        <li><a href="/shop.php">Shop</a></li>
        <li><a href="/about.php">About</a></li>
        <li><a href="/blog.php">Blog</a></li>
        <li><a href="/contact.php">Contact</a></li>
        <li><a href="/upload.php">Upload</a></li>
        <li><form method="post" action="logout.php">
          <input class="logoutt" style="background-color:transparent;border: none;font-weight: 600;font-family: 'Times New Roman', Times, serif;font-size: 16px;" type="submit" id="signOut" value="SignOut">
        </form></li>
        <li><a id="lg-bag" href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
        <a id="close"><i class="fa-solid fa-x"></i></a>
      </ul>
    </div>
    <div id="mobile">
      <i id="bar" class="fas fa-outdent"></i>
      <a href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</section>
    
  <section id="hero">
      <h4>Trade-in-offer</h4>
      <h2>Super value deals </h2>
      <h1>On all products</h1>
      <p>Save more coupons & up to 70% off!</p>
      <a href="/shop.php"><button>Shop Now</button></a>
  </section>
  <section id="feature" class="section-p1">
    <div class="fe-box">
      <img src="/imgweb/f1.png" alt="">
      <h6>Free Shipping</h6>
    </div>
    <div class="fe-box">
      <img src="/imgweb/f2.png" alt="">
      <h6>Online Order</h6>
    </div>
    <div class="fe-box">
      <img src="/imgweb/f3.png" alt="">
      <h6>Save Money</h6>
    </div>
    <div class="fe-box">
      <img src="/imgweb/f4.png" alt="">
      <h6>Promotions</h6>
    </div>
    <div class="fe-box">
      <img src="/imgweb/f5.png" alt="">
      <h6>Happy Sell</h6>
    </div>
    <div class="fe-box">
      <img src="/imgweb/f6.png" alt="">
      <h6>24/7 Support</h6>
    </div>

  </section>
  <section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
    <?php
        $conn = new mysqli("localhost", "root", "", "ecommerce");
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        // Featured Products
        $query = "SELECT p.*, i.image_url 
                FROM products p
                INNER JOIN images i ON p.image_id = i.id
                ORDER BY RAND() LIMIT 8";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="pro">
                    <a style="text-decoration:none;" href="s-prooducts.php?id=' . htmlspecialchars($row['id']) . '">
                        <img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name_of_product']) . '">
                        <div class="des">
                            <span>ROA</span>
                            <h5>' . htmlspecialchars($row['name_of_product']) . '</h5>
                            <h4>$' . number_format($row['price'], 2) . '</h4>
                        </div>
                    </a>
                    <form method="post" action="add_to_carthome.php">
                        <input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">
                        <button type="submit" class="cart-button"><i class="fas fa-cart-plus cart"></i></button>
                    </form>
                </div>';
            }
        } else {
            echo '<p>No products found</p>';
        }
        ?>
    </div>
  </section>

  <section id="banner" class="section-m1">
    <h4> Repair Services </h4>
    <h2>Up to <span>70% Off</span> - All t-Shirts & Accessories</h2>
    <button class="normal">Explore More</button>
  </section>
  <section id="product1" class="section-p1">
    <h2>New Arrivals</h2>
    <p>Latest products added in the last 24 hours</p>
    <div class="pro-container">
    <?php
        // New Arrivals (last 24 hours)
        $newArrivalsQuery = "SELECT p.*, i.image_url 
                           FROM products p
                           INNER JOIN images i ON p.image_id = i.id
                           WHERE p.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)
                           ORDER BY p.created_at DESC
                           LIMIT 8";
        $newArrivalsResult = $conn->query($newArrivalsQuery);

        if ($newArrivalsResult && $newArrivalsResult->num_rows > 0) {
            while ($newProduct = $newArrivalsResult->fetch_assoc()) {
                echo '
                <div class="pro">
                    <a style="text-decoration:none;" href="s-prooducts.php?id=' . htmlspecialchars($newProduct['id']) . '">
                        <img src="' . htmlspecialchars($newProduct['image_url']) . '" alt="' . htmlspecialchars($newProduct['name_of_product']) . '">
                        <div class="des">
                            <span>ROA</span>
                            <h5>' . htmlspecialchars($newProduct['name_of_product']) . '</h5>
                            <div class="star">
                                <i class="fas fa-star" style="color:goldenrod"></i>
                                <i class="fas fa-star" style="color:goldenrod"></i>
                                <i class="fas fa-star" style="color:goldenrod"></i>
                                <i class="fas fa-star" style="color:goldenrod"></i>
                                <i class="fas fa-star" style="color:goldenrod"></i>
                            </div>
                            <h4>$' . number_format($newProduct['price'], 2) . '</h4>
                        </div>
                    </a>
                    <form method="post" action="add_to_carthome.php">
                        <input type="hidden" name="product_id" value="' . htmlspecialchars($newProduct['id']) . '">
                        <button type="submit" class="cart-button"><i class="fas fa-cart-plus cart"></i></button>
                    </form>
                </div>';
            }
        } else {
            echo '<p>No new arrivals in the last 24 hours</p>';
        }
        $conn->close();
        ?>
    </div>
  </section>
  <section id="sm-banner" class="section-p1">
    <div class="banner-box">
      <h4>crazy deals</h4>
      <h2>buy 1 get 1 free</h2>
      <span>The best classic dress is on sale at cara</span>
      <button class="normal">Learn More</button>
    </div>
    <div class="banner-box banner-box2">
      <h4>spring/summer</h4>
      <h2>upcomming season</h2>
      <span>The best classic dress is on sale at cara</span>
      <button class="normal">Collection</button>
    </div>
  </section>
  <section id="banner3">
    <div class="banner-box">
      <h2>SEASONAL SALE</h2>
      <h3>Winter Collection - 50% OFF</h3>
    </div>
    <div class="banner-box banner-box2">
      <h2>SEASONAL SALE</h2>
      <h3>Winter Collection - 50% OFF</h3>
    </div>
    <div class="banner-box banner-box3">
      <h2>SEASONAL SALE</h2>
      <h3>Winter Collection - 50% OFF</h3>
    </div>
  </section>
  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Sign Up For Newsletters</h4>
      <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
    </div>
    <div class="form">
      <input type="email" name="email" placeholder="Your email address">
      <button class="normal">Sign Up</button>
    </div>
  </section>
  <footer class="section-p1">
    <div class="col">
      <img src="/imgweb/logo.png" style="width: 75px;" class="logo" alt="Logo">
      <h4>Contact</h4>
      <p><strong>Address:</strong> 562 Wellington Road, Street 32, San Francisco</p>
      <p><strong>Phone:</strong> +01 2222 3333</p>
      <p><strong>Hours:</strong> 10:00 - 18:00, Mon-Fri</p>
      <div class="follow">
        <h4>Follow us:</h4>
        <div class="icon">
          <i class="fab fa-facebook"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-pinterest"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-youtube"></i>
        </div>
      </div>
    </div>
    <div class="col">
      <a href="/about.php">About us</a>
      <a href="#">Delivery Information</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Conditions</a>
      <a href="/contact.php">Contact Us</a>
    </div>
    <div class="col">
      <h4>My Account</h4>
      <a href="/login.php">Sign In</a>
      <a href="/cart.php">View Cart</a>
      <a href="#">My Wishlist</a>
      <a href="#">Track My Order</a>
      <a href="/contact.php">Help</a>
    </div>
    <div class="col install">
      <h4>Install Apps</h4>
      <p>From App Store or Google Play</p>
      <div class="row">
        <img src="/imgweb/pay/app.jpg" alt="">
        <img src="/imgweb/pay/play.jpg" alt="">
      </div>
      <p>Secured Payment Gateways</p>
      <img src="/imgweb/pay/pay.png" alt="">
    </div>
    
    <div class="copyright">
      <p>HTML CSS JS</p>
    </div>

  </footer>
    <script src="/script.js"></script>
</body>
</html>
