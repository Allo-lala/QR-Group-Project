<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the form data is set
if (isset($_POST['id']) && isset($_FILES['qrImage'])) {
    $id = $_POST['id'];
    $qrImage = $_FILES['qrImage'];

    // Ensure the ID is an integer
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo json_encode(["message" => "Invalid product ID."]);
        exit();
    }

    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Generate a unique filename for the image
    $fileName = uniqid() . '_' . basename($qrImage['name']);
    $filePath = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($qrImage['tmp_name'], $filePath)) {
        $imageUrl = $filePath;

        // Prepare the SQL statement to update the product
        $dbh = new mysqli('localhost', 'root', '', 'lsk_db');
        if ($dbh->connect_error) {
            die(json_encode(["message" => "Connection failed: " . $dbh->connect_error]));
        }

        $stmt = $dbh->prepare("UPDATE Products SET qr_img = ? WHERE id = ?");
        $stmt->bind_param("si", $imageUrl, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product updated successfully!", "imageUrl" => $imageUrl]);
        } else {
            echo json_encode(["message" => "Error updating product: " . $stmt->error]);
        }

        $stmt->close();
        $dbh->close();
    } else {
        echo json_encode(["message" => "Error saving image."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
