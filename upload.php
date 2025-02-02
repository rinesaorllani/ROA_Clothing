<?php
session_start();

if(!isset($_SESSION["userId"])){
    echo "Access denied because you are not logged in!";
    header("Location:login.php");
    die();
}
if($_SESSION["role"] !== "admin"){
    echo "Access denied because you are not an admin!";
    header("Location:home.php");
    die();
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $client_id = "887dd5688d9f063"; // Replace with your actual Imgur Client ID
    $image = file_get_contents($_FILES["image"]["tmp_name"]);
    $imageData = base64_encode($image);

    $url = "https://api.imgur.com/3/image";
    $headers = ["Authorization: Client-ID $client_id"];
    $postData = ["image" => $imageData];

    // cURL request to Imgur API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);
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

    $id = generateUUID();
    $productid = generateUUID();
    $name = trim($_POST["name_of_product"]);
    $price = trim($_POST["price"]);
    $type = trim($_POST["type"]);
    $description = trim($_POST["description"]);
    $responseData = json_decode($response, true);

    if ($responseData && isset($responseData["data"]["link"])) {
        $imageUrl = $responseData["data"]["link"];

        // Save the image URL to the database
        $conn = new mysqli("localhost", "root", "", "ecommerce");
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO images (id,image_url) VALUES (?,?)");
        $stmt->bind_param("ss",$id, $imageUrl);
        if ($stmt->execute()) {
            echo "Image uploaded successfully!";
        } else {
            echo "Failed to save image URL to the database.";
        }

        $stmt = $conn-> prepare("INSERT INTO products(id,name_of_product,type_of_product,image_id,price,description_product) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss",$productid,$name,$type,$id,$price,$description);
        if ($stmt->execute()) {
            echo "product uploaded successfully!";
        } else {
            echo "Failed to save product to the database.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Failed to upload image to Imgur.";
    }
    
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link rel="stylesheet" href="styleA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="background-uploaddd">
        <form method="post" class="upload" enctype="multipart/form-data">
            <span>Upload a Product!</span>
            <input type="text" placeholder="Name" name="name_of_product" id="">
            <input type="text" name="type" placeholder="Type" id="">
            <input type="text" name="price" placeholder="Price" id="">
            <textarea placeholder="Description" name="description" id="" rows="3" cols="25"></textarea>
            <input type="file" name="image" accept="image/*" required>
            <button id="uploadstyle" style="padding: 1em 2em 1em 2em; border-radius:20px" type="submit">Upload</button>
        </form>
    </div>
    
</body>
</html>
