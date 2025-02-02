<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "ecommerce");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID not specified!");
}
$product_id = $conn->real_escape_string($_GET['id']);

// Fetch product details
$query = "SELECT p.*, i.image_url 
          FROM products p
          JOIN images i ON p.image_id = i.id
          WHERE p.id = '$product_id'";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("Product not found!");
}

$product = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name_of_product']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section id="header">
        <a href="/home.php" class="navbar-logo"><img src="/imgweb/logo.png" style="width: 75px;" class="logo" alt="Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="/home.php">Home</a></li>
                <li><a href="/shop.php">Shop</a></li>
                <li><a href="/about.php">Blog</a></li>
                <li><a href="/blog.php">About</a></li>
                <li><a href="/contact.php">Contact</a></li>
                <li><a href="/upload.php">Upload</a></li>
                <li><a href="/login.php">LogIn</a></li>
                <li><a href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
        <div id="mobile">
          <i id="bar" class="fas fa-outdent"></i>
          <a href="/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </section>

   <section id="prodetails" class="section-p1">
    <div class="single-pro-image">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" width="100%" id="MainImg">
        <div class="small-img-group">
            
        </div>
    </div>

    <div class="single-pro-details">
        <h6>Home / <?php echo htmlspecialchars($product['type_of_product']); ?></h6>
        <h4><?php echo htmlspecialchars($product['name_of_product']); ?></h4>
        <h2><?php echo number_format($product['price'], 2); ?>€</h2>
        <select>
            <option>Select Size</option>
            <option>XL</option>
            <option>L</option>
            <option>M</option>
            <option>S</option>
        </select>
        <input type="number" value="1">

        <form method="post" action="/add_to_carthome.php"><button type="submit" class="normal">Add To Cart</button></form>

        
        <h4>Product Details</h4>
        <div class="description-box">
            <span><?php echo nl2br(htmlspecialchars($product['description_product'])); ?></span>
        </div>
        
    </div>
   </section>

   <!-- Rest of your page remains the same -->
   <!-- ... -->



<script src="script.js"></script>
</body>
</html>
