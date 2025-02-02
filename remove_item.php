<?php
session_start();
if (!isset($_SESSION["userId"])) {
    header("Location: login.php");
    die();
}

if (isset($_GET['product_id'])) {
    $conn = new mysqli("localhost", "root", "", "ecommerce");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION["userId"];
    $productId = $_GET['product_id'];

    // Validate UUID format
    if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $productId)) {
        die("Invalid product ID format");
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ss", $userId, $productId);
    
    if ($stmt->execute()) {
        header("Location: cart.php?message=Item+removed");
    } else {
        header("Location: cart.php?error=Remove+failed");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: cart.php");
}
exit();
?>
