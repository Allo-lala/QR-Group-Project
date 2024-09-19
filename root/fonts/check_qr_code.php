<?php
include './root/config.php';

// Get data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $productId = $data['id'];

    // Check if QR code already exists for this product ID
    $stmt = $dbh->prepare("SELECT file_path FROM qr_codes WHERE product_id = ?");
    $stmt->execute([$productId]);
    $existingQrCode = $stmt->fetchColumn();

    if ($existingQrCode) {
        // Return a specific message indicating the QR code already exists
        echo json_encode(['status' => 'exists', 'message' => 'Product key has already been used.', 'qrImage' => $existingQrCode]);
    } else {
        // Return a message indicating no QR code exists for this product ID
        echo json_encode(['status' => 'not_exists', 'message' => 'Product key is available.']);
    }
} else {
    echo json_encode(['error' => 'Invalid data']);
}
?>
