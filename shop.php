<?php
session_start();
if (!isset($_SESSION["userId"])) {
    header("Location: login.php");
    die();
}

$conn = new mysqli("localhost", "root", "", "ecommerce");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define pagination variables
$limit = 24; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1
$offset = ($page - 1) * $limit; // Calculate offset for SQL query

// Get total number of products
$total_query = "SELECT COUNT(*) AS total FROM products";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products for current page
$query = "SELECT p.*, i.image_url 
          FROM products p
          INNER JOIN images i ON p.image_id = i.id
          LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E commerce project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section id="header">
        <a href="/home.php" class="navbar-logo"><img src="/imgweb/logo.png" class="logo" alt="Logo" style="width: 75px;"></a>
        <div>
          <ul id="navbar">
            <li><a href="/home.php">Home</a></li>
            <li><a class="active" href="/shop.php">Shop</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/blog.php">Blog</a></li>
            <li><a href="/contact.php">Contact</a></li>
            <li><a href="/upload.php">Upload</a></li>
            <li><form method="post" action="logout.php">
                <input class="logoutt" style="border: none;font-weight: 600;font-family: 'Times New Roman', Times, serif;font-size: 16px;" type="submit" id="signOut" value="SignOut">
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

    <section id="page-header"  style="background-image: url(imgweb/Banner/b7.jpg);">
        
        <h2>#Shop</h2>
       
        <p>Save more with cupons & up to 70% off!</p>
        
    </section>
    <section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
    <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="pro">
                    <a style="text-decoration:none;color:black;" href="s-prooducts.php?id=' . htmlspecialchars($row['id']) . '">
                        <img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name_of_product']) . '">
                        <div class="des">
                            <span>ROA</span>
                            <h5>' . htmlspecialchars($row['name_of_product']) . '</h5>
                            <h4>$' . number_format($row['price'], 2) . '</h4>
                        </div>
                    </a>
                    <form method="post" action="add_to_cart.php" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="'.$row['id'].'">
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

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>SignUp for NewsLetters</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers</span>.</p> 
        </div> 
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>

        </div>    
    </section>
    <section id="pagination"style="section-p1">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-arrow-left"></i> Prev</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>">Next <i class="fa-solid fa-arrow-right"></i></a>
        <?php endif; ?>

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
          <a href="about.php">About us</a>
          <a href="#">Delivery Information</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
          <a href="contact.php">Contact Us</a>
        </div>
        <div class="col">
          <h4>My Account</h4>
          <a href="login.php">Sign In</a>
          <a href="cart.php">View Cart</a>
          <a href="#">My Wishlist</a>
          <a href="#">Track My Order</a>
          <a href="contact.php">Help</a>
        </div>
        <div class="col install">
          <h4>Install Apps</h4>
          <p>From App Store or Google Play</p>
          <div class="row">
            <img src="imgweb/logo/appstore.jpg" alt="">
            <img src="imgweb/logo/googleplay.jpg" alt="">
          </div>
          <p>Secured Payment Gateways</p>
          <img src="imgweb/Pay/visa.png" alt="">
        </div>
        
        <div class="copyright">
          <p>HTML CSS JS</p>
        </div>
    
      </footer>
        <script src="/script.js"></script>
    </body>
    </html>
    <?php
$conn->close();
?>
   
