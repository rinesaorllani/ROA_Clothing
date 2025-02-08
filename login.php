
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" href="/styleA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "ecommerce";

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    if ($conn->connect_error) {
        $_SESSION["error"] = "Could not connect to the database!";
        header("Location: login.php");
        die();
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user by email
    $findUser = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $findUser->bind_param("s", $email);
    $findUser->execute();
    $userResult = $findUser->get_result();

    if ($userResult->num_rows == 0) {
        $_SESSION["error"] = "Incorrect email or password. Please try again!";
        header("Location: login.php");
        die();
    }

    // Get user data
    $user = $userResult->fetch_assoc();
    
    // Verify password
    if (!password_verify($password, $user["password"])) {
        $_SESSION["error"] = "Incorrect email or password. Please try again!";
        header("Location: login.php");
        die();
    }

    // Login successful
    $_SESSION["userId"] = $user["id"];
    $_SESSION["firstName"] = $user["first_name"];
    $_SESSION["role"] = $user["role"]; 
    header("Location: home.php");
    die();
}
?>
<body>
    <div class="background-login">
        <?php
            if (isset($_SESSION["error"])) {
                echo '<div id="hana" style="border-radius:50px;padding:10px;background-color: rgb(186, 186, 186);border:#750000 2px solid;color: #750000; text-align: center; margin-top: 10px;">Incorrect email or password. Please try again!</div>';
                unset($_SESSION["error"]); // Clear the error message after displaying it
            }
        ?>
        <div class="login" id="logIn">
            <div>
                <div class="div-logins">
                    <button id="log" onclick="logIn()">LogIn</button>
                    <a href="/signup.php"><button>SignUp</button></a>
                </div>
                <form method="post" class="login-form">
                    <input type="email" required placeholder="Email" name="email">
                    <input type="password" required placeholder="Password" name="password" id="login-password">
                    <button>LogIn</button>
                </form> 
            </div>
        </div>
    </div>
    <script src="/script.js"></script>
</body>
</html>
