<?php
session_start();
if (!isset($_SESSION["userId"])) {
    header("Location: login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $conn = new mysqli("localhost", "root", "", "ecommerce");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION["userId"];
    $productId = $_POST['product_id'];

    // Validate UUID format
    if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $productId)) {
        die("Invalid product ID format");
    }

    // Check if product exists using prepared statement
    $checkProduct = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $checkProduct->bind_param("s", $productId);
    $checkProduct->execute();
    $checkResult = $checkProduct->get_result();

    if ($checkResult->num_rows === 0) {
        die("Product does not exist");
    }

    // Insert into cart using prepared statement
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $userId, $productId); // Both as strings if user_id is UUID
    
    if ($stmt->execute()) {
        header("Location: home.php");
    } else {
        // Handle duplicate entry gracefully
        if ($conn->errno === 1062) {
            header("Location: home.php?message=Item+already+in+cart");
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $checkProduct->close();
    $stmt->close();
    $conn->close();
} else {
    header("Location: home.php");
}
?>
