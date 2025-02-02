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

$userId = $_SESSION["userId"];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styleO.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <section id="header">
        <a href="/home.php" class="navbar-logo"><img src="/imgweb/logo.png" style="width: 75px;" class="logo" alt="Logo"></a>
        <div>
          <ul id="navbar">
            <li><a href="/home.php">Home</a></li>
            <li><a href="/shop.php">Shop</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/blog.php">Blog</a></li>
            <li><a href="/contact.php">Contact</a></li>
            <li><a href="/upload.php">Upload</a></li>
            <li><form method="post" action="logout.php">
              <input class="logoutt" style="background-color:transparent;border: none;font-weight: 600;font-family: 'Times New Roman', Times, serif;font-size: 16px;" type="submit" id="signOut" value="SignOut">
            </form></li>
            <li><a class="active" id="lg-bag" href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <a id="close"><i class="fa-solid fa-x"></i></a>
          </ul>
        </div>
        <div id="mobile">
          <i id="bar" class="fas fa-outdent"></i>
          <a href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#Your Cart</h2>
        <p>Review and manage your items</p>
    </section>
    
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
               </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.id, p.name_of_product, p.price, i.image_url 
                          FROM cart c
                          JOIN products p ON c.product_id = p.id
                          JOIN images i ON p.image_id = i.id
                          WHERE c.user_id = ?";
                
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'];
                        $total += $subtotal;
                        echo '
                        <tr>
                            <td><a href="remove_item.php?product_id='.$row['id'].'"><i class="far fa-times-circle"></i></a></td>
                            <td><img src="'.htmlspecialchars($row['image_url']).'" alt="'.htmlspecialchars($row['name_of_product']).'"></td>
                            <td>'.htmlspecialchars($row['name_of_product']).'</td>
                            <td>$'.number_format($row['price'], 2).'</td>
                            <td><input type="number" value="1" min="1"></td>
                            <td>$'.number_format($subtotal, 2).'</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Your cart is empty</td></tr>';
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon" name="coupon">
                <button class="normal">Apply</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td>$ <?php echo number_format($total, 2); ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$ <?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </table>
            <button class="normal">Proceed to checkout</button>
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
<?php
$conn->close();
?>
