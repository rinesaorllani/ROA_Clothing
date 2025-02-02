<?php
session_start();
if (!isset($_SESSION["userId"])) {
    header("Location: login.php");
    die();
}

// Email processing
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload

$emailSent = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_contact"])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            $mail = new PHPMailer(true);
            
            // SMTP Configuration for Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'auronismajli2001@gmail.com'; // Your Gmail
            $mail->Password = 'ucef priu ealt xevc'; // Google App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your@gmail.com', 'ROA Clothing'); // Same as username
            $mail->addAddress('ismajliart0@gmail.com'); // Where to receive emails
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Contact Form: $subject";
            $mail->Body = "
                <h2>New Contact Form Submission</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong></p>
                <p>$message</p>
            ";

            $mail->send();
            $emailSent = true;
        } catch (Exception $e) {
            $error = "Message could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php if ($emailSent): ?>
        <div class="alert success">Message sent successfully!</div>
    <?php elseif (!empty($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div id="header">
        <a href="/home.php" class="navbar-logo"><img src="/imgweb/logo.png" style="width: 75px;" class="logo" alt="Logo"></a>
        <div>
          <ul id="navbar">
            <li><a href="/home.php">Home</a></li>
            <li><a href="/shop.php">Shop</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/blog.php">Blog</a></li>
            <li><a class="active" href="/contact.php">Contact</a></li>
            <li><a href="/upload.php">Upload</a></li>
            <li><form method="post" action="logout.php">
              <input class="logoutt" style="background-color:transparent;border: none;font-weight: 600;font-family: 'Times New Roman', Times, serif;font-size: 16px;" type="submit" id="signOut" value="SignOut">
            </form>
            </li>
            <li><a id="lg-bag" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
        <a id="close"><i class="fa-solid fa-x"></i></a>
          </ul>
        </div>
        <div id="mobile">
          <i id="bar" class="fas fa-outdent"></i>
          <a href="#cart"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>

    <div id="page-header" class="about-header">
        <h2>#let's talk!</h2>
        <p>Leave a message , We'd love to hear from you!</p>
    </div>

    <div id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit one of our agency locations or contact us today</h2>
            <h3>Head Offices</h3>
            <div>
                <li>
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Prishtine Lorem, ipsum dolor.</p>
                </li>
                <li>
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Prishtine Lorem ipsum dolor sit.</p>
                </li>
                <li>
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Prishtine Lorem, ipsum.</p>
                </li>
                <li>
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Prishtine Lorem ipsum dolor sit amet consectetur.</p>
                </li>   
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1945
            4.196512509377!2d21.131306099099547!3d42.64874604811049!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4
            f13.1!3m3!1m2!1s0x13549f0039f3fc1f%3A0xe9ae04efc75bec01!2sUBT-Dukagjini!5e0!3m2!1sen!2s!4v17314951178
            09!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <div id="form-details">
    <form method="POST" action="contact.php">
        <h2>We love to hear from you!</h2>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
        <button type="submit" name="submit_contact" class="normal">Submit</button>
      </form>
      <div class="people">
          <div>
              <img src="/imgweb/people/1.png" alt="">
              <p><span>Name Surname</span>Senior Developer <br>
              Phone : 0033445544 <br>
              Email : contact@gmail.com
              </p>
          </div>
          <div>
              <img src="/imgweb/people/2.png" alt="">
              <p><span>Name Surname</span>Senior Developer <br>
              Phone : 0033445544 <br>
              Email : contact@gmail.com
              </p>
          </div>
          <div>
              <img src="/imgweb/people/3.png" alt="">
              <p><span>Name Surname</span>Senior Developer <br>
              Phone : 0033445544 <br>
              Email : contact@gmail.com
              </p>
        </div>
      </div>
    </div>

    <div id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
          <h4>Sign Up For Newsletters</h4>
          <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
          <input type="email" name="email" placeholder="Your email address">
          <button class="normal">Sign Up</button>
        </div>
    </div>
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
          <a href="#">About us</a>
          <a href="#">Delivery Information</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
          <a href="#">Contact Us</a>
        </div>
        <div class="col">
          <h4>My Account</h4>
          <a href="#">Sign In</a>
          <a href="#">View Cart</a>
          <a href="#">My Wishlist</a>
          <a href="#">Track My Order</a>
          <a href="#">Help</a>
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
          <p>2024 ,Tech etc - HTML CSS JS</p>
        </div>

    </footer>

    <script>
      document.getElementById("contactForm").addEventListener("submit", function (event) {
          event.preventDefault();

          const name = document.getElementById("name").value.trim();
          const email = document.getElementById("email").value.trim();
          const subject = document.getElementById("subject").value.trim();
          const message = document.getElementById("message").value.trim();

          let errorMessage = "";

          if (name === "") {
              errorMessage += "Name is required.\n";
          }

          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (email === "") {
              errorMessage += "Email is required.\n";
          } else if (!emailPattern.test(email)) {
              errorMessage += "Enter a valid email address.\n";
          }

          if (subject === "") {
              errorMessage += "Subject is required.\n";
          }

          if (message === "") {
              errorMessage += "Message is required.\n";
          }

          if (errorMessage) {
              alert(errorMessage);
          } else {
              alert("Form submitted successfully!");
              document.getElementById("contactForm").reset();
          }
      });
  </script>
</body>
</html>
