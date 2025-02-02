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
    <title>About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styleO.css">
</head>

<body>
    <section id="header">
      <a href="/home.php" class="navbar-logo"><img src="/imgweb/logo.png" style="width: 75px;" class="logo" alt="Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="/home.php">Home</a></li>
                <li><a href="/shop.php">Shop</a></li>
                <li><a class="active" href="/about.php">About</a></li>
                <li><a href="/blog.php">Blog</a></li>
                <li><a href="/contact.php">Contact</a></li>
                <li><a href="/upload.php">Upload</a></li>
                <li><form method="post" action="logout.php">
                  <input class="logoutt" style="background-color:transparent;border: none;font-weight: 600;font-family: 'Times New Roman', Times, serif;font-size: 16px;" type="submit" id="signOut" value="SignOut">
                </form></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
        <div id="mobile">
          <i id="bar" class="fas fa-outdent"></i>
          <a href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </section>

    <section id="page-header" style="background-image: url(/imgweb/banner/b7.jpg);" class="about-header">

        
        <h2>#knowUs</h2>
       
        <p>There is all you need to know about us!</p>
        
    </section>

    <section id="about-head" class="section-p1">
        <img src="/imgweb/about/a6.jpg" alt="">
        <div>
            <h2>Who We Are?</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Perferendis voluptatem accusantium nisi rem blanditiis deserunt!
                Quia iusto eius repellendus natus recusandae adipisci consequatur mollitia,
                 a sint et quod temporibus non at reiciendis quam ad veniam nihil. 
                 Est in odit labore dicta excepturi,
                sint veniam autem optio doloribus, facere magnam dolorem?</p>
                <abbr title="">
                    Create stunning images with as much or as little control as you
                    like thanks to a choice of Basic and Creative modes</abbr>

                <br><br>
                <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%" direction="">
                    Create stunning images with as much or as little control as you like thanks to a
                    choice of Basic and Creative modes.
                </marquee>

        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Download our <a href="#">App</a></h1>
        <div class="video">
            <video muted autoplay loop src="/imgweb/about/1.mp4"></video>
        </div>

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

   
