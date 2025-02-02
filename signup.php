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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["birthday"], $_POST["role"])) {
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "ecommerce";

        $conn = new mysqli($servername, $username, $password, $dbName);

        if ($conn->connect_error) {
            $_SESSION["error"] = "Database connection failed!";
            header("Location: signup.php");
            exit();
        }

        // Generate a unique UUID
        function generateUUID() {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }

        $userId = generateUUID();
        $firstName = trim($_POST["firstName"]);
        $lastName = trim($_POST["lastName"]);
        $email = trim($_POST["email"]);
        $userPassword = password_hash($_POST["password"], PASSWORD_BCRYPT); // Secure password
        $birthday = $_POST["birthday"];
        $role = $_POST["role"];

        // Check for duplicate email
        $checkDuplicate = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkDuplicate->bind_param("s", $email);
        $checkDuplicate->execute();
        $duplicateResult = $checkDuplicate->get_result();

        if ($duplicateResult->num_rows > 0) {
            $_SESSION["error"] = "Email is already registered!";
            header("Location: signup.php");
            exit();
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (id, first_name, last_name, email, password, birthday, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $userId, $firstName, $lastName, $email, $userPassword, $birthday, $role);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Signup successful! Please log in.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION["error"] = "Signup failed. Try again.";
            header("Location: signup.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<body>
    <div class="background-login">
        <div class="login" id="signUp">
            <div>
                <div class="div-logins">
                    <a href="/login.php"><button>LogIn</button></a>
                    <button>SignUp</button>
                </div>
                <form method="post" class="login-form" id="login-form">
                    <input type="text" required placeholder="First Name" name="firstName" id="first-name">
                    <input type="text" required placeholder="Last Name" name="lastName" id="last-name">
                    <input type="email" required placeholder="Email" name="email" id="email">
                    <input type="password" required placeholder="Password" name="password" id="password">
                    <span style="width: 100%;">Birthday :</span>
                    <input style="width: 82%;" required type="date" name="birthday" id="birthday">
                    <span>Select your role:</span>
                    <select name="role" id="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="buyer">Buyer</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button>Submit</button>
                </form> 
            </div> 
        </div>
    </div>
    
</body>
</html>
